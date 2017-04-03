<?php

namespace Saritasa\DingoApi\Transformers;

use Illuminate\Contracts\Support\Arrayable;

class LimitFieldsTransformer extends BaseTransformer
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
