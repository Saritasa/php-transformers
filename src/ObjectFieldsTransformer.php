<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

class ObjectFieldsTransformer extends BaseTransformer
{
    /**
     * Only these fields should be returned
     *
     * @var string[] array
     */
    private $onlyFields;

    function __construct(string ...$onlyFields)
    {
        $this->onlyFields = $onlyFields;
    }

    public function transform(Arrayable $object)
    {
        $result = [];
        foreach ($this->onlyFields as $field) {
            if (str_contains($field, '.')) {
                $result[$field] = $this->getFieldRecursive($object, $field);
            }
            $result[$field] = $object->$field;
        }
        return $result;
    }

    public function getFieldRecursive($object, $field) {
        $fields = explode('.', $field);
        $result = $object;
        foreach ($fields as $field) {
            if ($result == null){
                break;
            }
            $result = $object->$field;
        }
        return $result;
    }
}