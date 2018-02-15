<?php

namespace Saritasa\Transformers\Tests;

/**
 * Imaginable User model
 *
 * @property string $first_name
 * @property string $last_name
 * @property-read string $full_name
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon $birthday
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    static $unguarded = true;

    protected $visible = ['full_name', 'created_at'];
    protected $hidden = ['email', 'password'];
    protected $dates = ['created_at', 'updated_at', 'birthday'];
}
