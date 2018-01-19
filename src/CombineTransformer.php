<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Applies a sequence of transformations, one by one
 */
class CombineTransformer extends BaseTransformer
{
    /**
     * Transformers to apply sequentially
     *
     * @var IDataTransformer[]
     */
    private $transformers;

    public function __construct(IDataTransformer ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * Transform model into array
     *
     * @param Arrayable $model Model to be transformed
     * @return array
     */
    public function transform(Arrayable $model)
    {
        $model = array_reduce($this->transformers, function ($carry, IDataTransformer $transformer) {
            return collect($transformer->transform($carry));
        }, $model);
        return parent::transform($model);
    }
}
