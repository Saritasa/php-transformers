<?php

namespace Saritasa\Transformers\Tests;

use Carbon\Carbon;
use Saritasa\Transformers\BaseTransformer;
use Saritasa\Transformers\DtoModel;

class BaseTransformerTest extends TestCase
{
    function testModelTransform()
    {
        $createdAt = '2017-06-15 06:31:07';

        $user = new User([
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov',
            'full_name' => 'Ivan Ivanov',
            'birthday' => Carbon::parse('1985-06-15'),
            'created_at' => Carbon::parse($createdAt),
            'updated_at' => Carbon::parse('2017-06-15 06:31:07'),
        ]);
        $user->email = 'ivan@example.com';

        $transformer = new BaseTransformer();
        $result = $transformer->transform($user);

        static::assertEquals(count($user->getVisible()), count($result));
        static::assertArrayHasKey('full_name', $result);
        static::assertArrayNotHasKey('email', $result);
        static::assertEquals(Carbon::parse($createdAt)->format(Carbon::ISO8601), $result['created_at']);
    }

    function testArrayTransform()
    {
        $birthday = '2017-06-15';

        $user = new class (['name' => 'Ivan', 'birthday' => Carbon::parse($birthday)]) extends DtoModel
        {
            protected $name;
            protected $birthday;
        };

        $transformer = new BaseTransformer();
        $result = $transformer->transform($user);

        static::assertEquals(count($user->toArray()), count($result));
        static::assertArrayHasKey('name', $result);
        static::assertArrayHasKey('birthday', $result);
        static::assertEquals(Carbon::parse($birthday)->format(Carbon::ISO8601), $result['birthday']);
    }
}
