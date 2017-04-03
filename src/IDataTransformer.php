<?php

namespace Saritasa\DingoApi\Transformers;

use Illuminate\Contracts\Support\Arrayable;

interface IDataTransformer
{
    function transform(Arrayable $model);
}
