<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;

interface IDataTransformer
{
    function transform(Arrayable $model);
}
