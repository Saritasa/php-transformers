<?php

namespace Saritasa\Transformers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

/**
 * Converts model to raw array.
 * If model has date fields, converts them to ISO 8601 format
 */
class BaseTransformer extends TransformerAbstract implements IDataTransformer
{
    public function transform(Arrayable $model)
    {
        $result = $model->toArray();
        if ($model instanceof Model) {
            $result = $this->datesToISO8601($result, $model);
            $result = $this->removeHiddenFields($result, $model);
        }
        return $result;
    }

    /**
     * Convert dates to ISO 8601 format (includes time zone)
     *
     * @param array $result model, serialized to array
     * @param Model $model original Eloquent model
     * @return array
     */
    protected function datesToISO8601(array $result, Model $model)
    {
        $dateFields = $model->getDates();
        if ($dateFields && count($dateFields) > 0) {
            foreach ($dateFields as $field) {
                $value = $model->getAttributeValue($field);
                $result[$field] = $value ? $value->format(Carbon::ISO8601) : $value;
            }
        }
        return $result;
    }

    /**
     * Force remove hidden fields.
     * For some reason toArray() may ignore $visible and $hidden Eloquent fields
     *
     * @param array $result model, serialized to array
     * @param Model $model original Eloquent model
     * @return array
     */
    protected function removeHiddenFields(array $result, Model $model)
    {
        $hiddenFields = $model->getHidden();
        if ($hiddenFields && count($hiddenFields) > 0) {
            foreach ($hiddenFields as $field) {
                if (array_key_exists($field, $result)) {
                    unset($result[$field]);
                }
            }
        }
        return $result;
    }
}
