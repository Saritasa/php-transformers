<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Applies a sequence of transformations, one by one
 */
class CombineTransformer extends BaseTransformer
{
    /**
     * @var IDataTransformer[]
     */
    private $transformers;

    function __construct(IDataTransformer ...$transformers)
    {
        $this->transformers = $transformers;
    }

    function transform(Arrayable $model)
    {
        $model = array_reduce($this->transformers, function($carry, IDataTransformer $transformer) {
            return collect($transformer->transform($carry));
        }, $model);
        return parent::transform($model);
    }
}