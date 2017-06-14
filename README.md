# Data Transformers

Custom Data transformers on top of League/Fractal library.

See http://fractal.thephpleague.com/
https://github.com/thephpleague/fractal


## Laravel 5.x

Install the ```saritasa/transformers``` package:

```bash
$ composer require saritasa/transformers
```

Add the TransformersServiceProvider service provider in ``config/app.php``:

```php
'providers' => array(
    // ...
    Saritasa\Transformers\TransformersServiceProvider::class,
)
```

## Available transformers

### IDataTransformer
Interface to unlink dependency from League/Fractal library.
Ensure, that every transformer implementation in this library has this interface.

**Example**:
```
class AnotherTransformerWrapper implements IDataTransformer
{
    public function __construct(IDataTransformer $nestedTransformer) {}
}
```

### CombineTransformer
Apply multiple transformers in order of arguments;

**Example**:
```
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
Result will contain only selected fields from source object.

**Example**:
```php
$publicUserProfileTransformer = new LimitFieldsTransformer('id', 'name', 'created_at');

```

## Exceptions
### TransformException
Should be thrown by class, implementing IDataTransformer, if it encounters data,
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

## Utility Classes

### DtoModel
Allows you to use pure DTO models instead of Eloquent, while using Fractal for
collection transformation.

## Contributing

1. Create fork
2. Checkout fork
3. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)**
4. Update [README.md](README.md) to describe new or changed functionality. Add changes description to [CHANGES.md](CHANGES.md) file.
5. When ready, create pull request

## Resources

* [Bug Tracker](http://github.com/saritasa/php-transformers/issues)
* [Code](http://github.com/saritasa/php-transformers)
* [Changes History](CHANGES.md)
* [Authors](http://github.com/saritasa/php-transformers/contributors)
