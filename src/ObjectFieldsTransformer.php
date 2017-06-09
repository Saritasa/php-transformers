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
            $result[$field] = $object->$field;
        }
        return $result;
    }
}