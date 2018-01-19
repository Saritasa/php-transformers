<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

/**
 *  Result will first apply ->toArray() method (which acts, respecting Eloquent's
 *  *$visible* and *$hidden* fields), then limits output to selected fields.
 *  This, hidden fields will not get in output, even if listed.
 */
class LimitFieldsTransformer extends BaseTransformer
{
    /**
     * Only these fields should be returned
     *
     * @var string[] array
     */
    private $onlyFields;

    /**
     *  Result will first apply ->toArray() method (which acts, respecting Eloquent's
     *  *$visible* and *$hidden* fields), then limits output to selected fields.
     *  This, hidden fields will not get in output, even if listed.
     *
     * @param string[] $onlyFields list of fields, to which result must be limited
     */
    public function __construct(string ...$onlyFields)
    {
        $this->onlyFields = $onlyFields;
    }

    /**
     * Transform model into array
     *
     * @param Arrayable $model Model to be transformed
     * @return array
     */
    public function transform(Arrayable $model)
    {
        $data = parent::transform($model);
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->onlyFields)) {
                unset($data[$key]);
            }
        }
        return $data;
    }
}
