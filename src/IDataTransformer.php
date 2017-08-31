<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

interface IDataTransformer
{
    public function transform(Arrayable $model);
}
