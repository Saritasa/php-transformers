<?php

namespace App\Api\V1\Responses;

use App\Http\Traits\SimpleJsonSerialize;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class DtoModel implements Arrayable, Jsonable, \JsonSerializable
{
    public static $snakeAttributes = true;
    protected static $collectionKey = 'results';
    protected static $propertiesCache;

    use SimpleJsonSerialize;

    public function getTable()
    {
        return static::$collectionKey;
    }

    public function toArray() {
        $result = [];
        foreach (static::getInstanceProperties() as $key) {
            $result[$key] = $this->$key;
        }
        return $result;
    }

    private static function getInstanceProperties()
    {
        if (!static::$propertiesCache) {
            static::$propertiesCache = [];
            $reflect = new \ReflectionClass(static::class);
            foreach ($reflect->getProperties() as $property) {
                if (!$property->isStatic()){
                    static::$propertiesCache[] = $property->getName();
                }
            }
        }
        return static::$propertiesCache;
    }
}
