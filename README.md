# Data Transformers

Custom Data transformers on top of [League/Fractal](https://github.com/thephpleague/fractal) library.

See Fractal documentation at http://fractal.thephpleague.com/


## Laravel 5.x

Install the ```saritasa/transformers``` package:

```bash
$ composer require saritasa/transformers
```

If you use Laraval 5.4 or less,
or 5.5 with [package discovery](https://laravel.com/docs/5.5/packages#package-discovery) disabled,
add the TransformersServiceProvider service provider in ``config/app.php``:

```php
'providers' => array(
    // ...
    Saritasa\Transformers\TransformersServiceProvider::class,
)
```

This is required for [localization](https://laravel.com/docs/localization) to work properly.

## Available transformers

### IDataTransformer
Interface to unlink dependency from League/Fractal library.
Ensure, that every transformer implementation in this library has this interface.

**Example**:
```php
class AnotherTransformerWrapper implements IDataTransformer
{
    public function __construct(IDataTransformer $nestedTransformer) { ... }
}
```

### BaseTransformer
When you just need to convert model to JSON response via Dingo/Api methods,
and have no specific formatting requirements, you can just use
**BaseTransformer**. It calls **Arrayable->toArray()** method.
Thus, for Eloquent model result will consist of fields,
described as *$visible* and not *$hidden.*
Additionally converts fields, enumerated in *$dates* to ISO8061 format.

**Example**:
```php

class User extends \Illuminate\Database\Eloquent\Model {
    // "full_name" is a property calculated from first_name and last_name
    protected $visible = ['full_name', 'created_at'];
    protected $hidden = ['email', 'password'];
    protected $dates = ['created_at', 'updated_at', 'birthday'];
}

class UserController extends BaseApiController {
    public function myProfile(): \Dingo\Api\Http\Response {
        $user = $this->user(); // Returns Eloquent model
        return $this->response->item($user, new BaseTransformer);
        // Output will be JSON
        // { "full_name": "Ivan Ivanov", "created_at": "2017-04-12T23:20:50.52Z" }
    }
}

$user = User::find($userId);

```

### ObjectFieldsTransformer
Will output requested fields to result, regardless they described as
*$hidden* or *$visible* in Eloquent model

**Example**:
```php

class User extends \Illuminate\Database\Eloquent\Model {
    // "full_name" is a property calculated from first_name and last_name
    protected $visible = ['full_name', 'created_at'];
    protected $hidden = ['email', 'password'];
    protected $dates = ['created_at', 'updated_at', 'birthday'];
}

class UserController extends BaseApiController {
    public function myProfile(): \Dingo\Api\Http\Response {
        $user = $this->user(); // Returns Eloquent model
        $profileTransformer = new ObjectFieldsTransformer('first_name', 'last_name', 'email', 'birthday');
        return $this->response->item($user, $profileTransformer);
        // Output will be JSON
        // { "first_name": "Ivan", "last_name": "Ivanov", "email": "ivanov@mail.ru", "birthday": "1985-04-12T00:00:00.00Z" }
    }
}

$user = User::find($userId);

```


### CombineTransformer
Apply multiple transformers in order of arguments;

**Example**:
```php

class UserProfileTransformer extends CombineTransformer
{
    public function __construct()
    {
        parent::__construct(
            new PreloadUserAvatarTransformer(),
            new PreloadUserSettingsTransformer()
        );
    }
}

```

### LimitFieldsTransformer
Result will first apply ->toArray() method (which acts, respecting Eloquent's
*$visible* and *$hidden* fields), then limits output to selected fields.
This, hidden fields will not get in output, even if listed.

**Example**:
```php

class User extends \Illuminate\Database\Eloquent\Model {
    protected $visible = ['full_name', 'created_at'];
    protected $hidden = ['email', 'password'];
    protected $dates = ['created_at', 'updated_at', 'birthday'];
}

class UserController extends BaseApiController {
    public function myProfile(): \Dingo\Api\Http\Response {
        $user = $this->user(); // Returns Eloquent model
        $publicProfileTransformer = new LimitFieldsTransformer('full_name', 'birthday');
        return $this->response->item($user, new BaseTransformer);
        // Output will be JSON
        // { "full_name": "Ivan Ivanov" }
    }
}

$user = User::find($userId);

```

## Exceptions
### TransformException
Should be thrown by class, implementing **IDataTransformer**, if it encounters data,
that cannot be transformed.

**Example**:
```php
function transform(Arrayable $data) {
    if (!$data->author) {
        new TransformException($this, "Author may not be empty");
    }
    // ...
}
```

### TransformTypeMismatchException
Should be thrown, if your transformer expects model of a certain type,
but gets another class.

```php
class UserTransformer extends BaseTransformer {
    public function transform(Arrayable $model) {
        if (!$model instanceof User) {
            throw new TransformTypeMismatchException($this, User::class, get_class($model));
        }

        return transformUser($model);
    }

    private function transformUser(User $user) {
        ... // Handle strong-typed model
    }
}

```

## Utility Classes

### DtoModel
Allows you to use pure DTO models instead of Eloquent, while using Fractal for
collection transformation.

## Contributing

1. Create fork
2. Checkout fork
3. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)**
4. Run [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) to ensure, that code follows style guides
5. Update [README.md](README.md) to describe new or changed functionality. Add changes description to [CHANGES.md](CHANGES.md) file.
6. When ready, create pull request

## Resources

* [Bug Tracker](http://github.com/saritasa/php-transformers/issues)
* [Code](http://github.com/saritasa/php-transformers)
* [Changes History](CHANGES.md)
* [Authors](http://github.com/saritasa/php-transformers/contributors)
