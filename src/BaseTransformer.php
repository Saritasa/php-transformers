<?php

namespace Saritasa\Transformers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

/**
 * Converts model to raw array.
 * If model has date fields, converts them to ISO 8601 format
 */
class BaseTransformer extends TransformerAbstract implements IDataTransformer
{
    /**
     * Default format of date that will be used to convert date fields
     *
     * @var string
     */
    protected $defaultDateTimeFormat = Carbon::ISO8601;

    /**
     * Transform model into array
     *
     * @param Arrayable $model Model to be transformed
     *
     * @return array
     */
    public function transform(Arrayable $model)
    {
        $result = $model->toArray();
        if ($model instanceof Model) {
            $result = $this->datesToISO8601($result, $model);
            $result = $this->removeHiddenFields($result, $model);
        } else {
            $result = $this->formatDatesInArray($result);
        }

        return $result;
    }

    /**
     * Converts dates in model to ISO 8601 format (includes time zone)
     *
     * @param array $result model, serialized to array
     * @param Model $model original Eloquent model
     *
     * @return array
     */
    protected function datesToISO8601(array $result, Model $model)
    {
        $dateFields = $model->getDates();
        if ($dateFields && count($dateFields) > 0) {
            foreach ($dateFields as $field) {
                $value = $model->getAttributeValue($field);
                $result[$field] = $value ? $value->format($this->defaultDateTimeFormat) : $value;
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
     *
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

        // If Eloquent model has both $hidden and $visible arrays then need to satisfy both restrictions
        $visibleFields = $model->getVisible();
        if ($visibleFields && count($visibleFields) > 0) {
            foreach ($result as $field => $value) {
                if (!in_array($field, $visibleFields)) {
                    unset($result[$field]);
                }
            }
        }

        return $result;
    }

    /**
     * Converts dates in array to ISO 8601 format (includes time zone)
     *
     * @param array $result Array in which need to convert dates
     *
     * @return array Result array with converted dates
     */
    protected function formatDatesInArray(array $result): array
    {
        foreach ($result as $attribute => $value) {
            if ($value instanceof DateTime) {
                $result[$attribute] = $value->format($this->defaultDateTimeFormat);
            }
        }

        return $result;
    }
}
