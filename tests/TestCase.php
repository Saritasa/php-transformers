<?php

namespace Tests;

use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\MySqlConnection;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
    {
        // Set fake DB connection resolver
        $dbConnectionResolver = new ConnectionResolver();
        $dbConnectionResolver->addConnection(null, new MySqlConnection(null));

        Model::setConnectionResolver($dbConnectionResolver);
    }
}