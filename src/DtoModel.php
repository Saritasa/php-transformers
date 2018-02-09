<?php

namespace Saritasa\Transformers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * DtoModel for transformers - compatible with Eloquent models, when Dingo/Api serializes response
 */
abstract class DtoModel extends \Saritasa\Dto implements Arrayable, Jsonable
{
    public static $snakeAttributes = true;
    protected static $collectionKey = 'results';

    public function getTable()
    {
        return static::$collectionKey;
    }
}
