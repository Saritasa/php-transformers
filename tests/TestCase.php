<?php

namespace Tests;

use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\MySqlConnection;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
    {
        $resolver = new ConnectionResolver();
        $resolver->addConnection(null, new MySqlConnection(null));
        Model::setConnectionResolver($resolver);
    }
}