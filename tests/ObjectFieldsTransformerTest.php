<?php

namespace Tests;

use Saritasa\Transformers\ObjectFieldsTransformer;

class ObjectFieldsTransformerTest extends TestCase
{
    public function testBasicExample()
    {
        $user = new User([
            'first_name' => 'Ivan',
            'last_name' => 'Ivanovich'
        ]);

        $user->setRelation('device', new UserDevice([
            'device_id' => 'somestr',
            'device_type' => 'android'
        ]));

        $transformer = new ObjectFieldsTransformer('first_name', 'device.device_type');
        $result = $transformer->transform($user);
        static::assertEquals(2, count(array_keys($result)));
        static::assertEquals('Ivan', $result['first_name']);
        static::assertEquals('android', $result['device.device_type']);
    }
}
