<?php

namespace Saritasa\Transformers;

use League\Flysystem\NotSupportedException;
use Saritasa\Transformers\Traits\SimpleJsonSerialize;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class DtoModel implements Arrayable, Jsonable, \JsonSerializable
{
    use SimpleJsonSerialize;

    public static $snakeAttributes = true;
    protected static $collectionKey = 'results';
    protected static $propertiesCache;

    public function __construct(array $data)
    {
        foreach (static::getInstanceProperties() as $key) {
            if (isset($data[$key])) {
                $this->$key = $data[$key];
            }
        }
    }

    public function getTable()
    {
        return static::$collectionKey;
    }

    public function toArray()
    {
        $result = [];
        foreach (static::getInstanceProperties() as $key) {
            $result[$key] = $this->$key;
        }
        return $result;
    }

    public function __get($name)
    {
        if (in_array($name, static::getInstanceProperties())) {
            return $this->$name;
        } else {
            throw new NotSupportedException("Requesting unavailable field: $name");
        }
    }

    private static function getInstanceProperties()
    {
        $class = static::class;
        if (!isset(static::$propertiesCache[$class])) {
            $cache = [];
            $reflect = new \ReflectionClass($class);
            foreach ($reflect->getProperties() as $property) {
                if (!$property->isStatic()) {
                    $cache[] = $property->getName();
                }
            }
            static::$propertiesCache[$class] = $cache;
        }
        return static::$propertiesCache[$class];
    }
}
