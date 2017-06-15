<?php

namespace Tests;

use Saritasa\Transformers\LimitFieldsTransformer;

class LimitFieldsTransformerTest extends TestCase
{
    function testUserTransform()
    {
        $user = new User([
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov',
            'full_name' => 'Ivan Ivanov',
            'birthday' => '1985-06-15',
            'created_at' => '2017-06-15 06:31:07',
            'updated_at' => '2017-06-15 06:31:07'
        ]);

        $transformer = new LimitFieldsTransformer('full_name');
        $result = $transformer->transform($user);

        static::assertEquals(1, count(array_keys($result)));
        static::assertArrayHasKey('full_name', $result);
        static::assertArrayNotHasKey('created_at', $result);
    }
}