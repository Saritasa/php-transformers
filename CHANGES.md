# Changes History

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
