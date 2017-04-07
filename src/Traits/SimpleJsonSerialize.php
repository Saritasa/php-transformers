<?php

namespace Saritasa\Transformers\Traits;

/**
 * Adds trivial methods to implement contracts Jsonable and JsonSerializable
 */
trait SimpleJsonSerialize
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}