<?php

namespace Saritasa\Transformers\Tests;

use Saritasa\Transformers\DtoModel;

class DtoModelTest extends TestCase
{
    public function testMultipleModelsPropertiesDoNotOverlap()
    {
        $address = new class ([]) extends DtoModel {
            protected $name;
            protected $address;
            protected $city;
            protected $state;
            protected $zip;
        };

        $result = $address->toArray();
        static::assertArrayHasKey('name', $result);
        static::assertArrayHasKey('address', $result);
        static::assertArrayHasKey('city', $result);
        static::assertArrayHasKey('state', $result);
        static::assertArrayHasKey('zip', $result);

        $answer = new class ([]) extends DtoModel {
            protected $text;
            protected $answerType;
        };

        $result2 = $answer->toArray();
        static::assertArrayHasKey('text', $result2);
        static::assertArrayHasKey('answerType', $result2);

        static::assertArrayNotHasKey('name', $result2);
        static::assertArrayNotHasKey('address', $result2);
        static::assertArrayNotHasKey('city', $result2);
        static::assertArrayNotHasKey('state', $result2);
        static::assertArrayNotHasKey('zip', $result2);
    }
}
