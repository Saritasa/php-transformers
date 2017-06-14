<?php

namespace Tests;

use Saritasa\Database\Eloquent\Models\User;
use Saritasa\PushNotifications\Models\UserDevice;
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
    }
}
