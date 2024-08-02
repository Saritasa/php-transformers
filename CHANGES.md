# Changes History

1.2.2
------
- Added support up to Laravel 11

1.2.1
------
- Fix ObjectFieldsTransformer on PHP 7.2+
- Add 7.3, 7.4 environments to test on Travis CI

1.2.0
------
Declare compatibility with Laravel 6

1.1.0
------
- Format passed into array dates in BaseTransformer. Previous version formats only dates in model
- Resolve issue with `$hidden` and `$visible` arrays of fields in model. Previously only `$hidden` was taken into account

1.0.17
------
Require saritasa/php-common after extracting base Dto class

1.0.16
------
Require newer version of league/fractal

1.0.15
------
- DtoModel extends Saritasa\Dto (previously was self-sufficient)
- NotSupportedException is deprecated. Use Saritasa\NotImplementedException instead

1.0.14
------
Do not require minimum-stability of packages

1.0.13
------
Enable Laravel's package discovery https://laravel.com/docs/5.5/packages#package-discovery

1.0.12
------
- Add NotSupportedException.
- Using in the DtoModel the Saritasa\Transformers\Exceptions\NotSupportedException instead the
- League\Flysystem\NotSupportedException.

1.0.11
------
Fix DtoModel different classes fields overlap + DtoModel unit test

1.0.10
------
- Add ObjectFieldsTransformer
- Fix message display

1.0.9
-----
Update dependencies versions

1.0.8
-----
Add:
- TransformTypeMismatchException
- TransformersServiceProvider

1.0.7
-----
Update dependencies versions

1.0.6
-----
- Move default pagination limits to saritasa/dingo-api-custom
- Remove TransformersProvider

1.0.3-1.0.5
-----
Fixes

1.0.2
-----
Add TransformException

1.0.1
-----
Fix namespace

1.0.0
-----
Initial version:
- IDataTransformer
- BaseTransformer
- LimitFieldsTransformer
- CombineTransformer
