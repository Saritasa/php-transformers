<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Will output requested fields to result, regardless they described as $hidden or $visible in Eloquent model
 */
class ObjectFieldsTransformer extends BaseTransformer
{
    /**
     * Only these fields should be returned
     *
     * @var string[] array
     */
    private $fields;

    /**
     * Will output requested fields to result, regardless they described as $hidden or $visible in Eloquent model
     *
     * @param string[] $fields Fields to include in result
     */
    public function __construct(string ...$fields)
    {
        $this->fields = $fields;
    }

    /**
     * Transform model into array
     *
     * @param Arrayable $model Model to be transformed
     * @return array
     */
    public function transform(Arrayable $object)
    {
        $result = [];
        foreach ($this->fields as $field) {
            if (str_contains($field, '.')) {
                $result[$field] = $this->getFieldRecursive($object, $field);
            } else {
                $result[$field] = $object->$field;
            }
        }
        return $result;
    }

    public function getFieldRecursive($object, $field)
    {
        $fields = explode('.', $field);
        $result = $object;
        foreach ($fields as $field) {
            if ($result == null) {
                break;
            }
            $result = $result->$field;
        }
        return $result;
    }
}
