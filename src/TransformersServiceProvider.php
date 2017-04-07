<?php

namespace Saritasa\Transformers;

use Illuminate\Support\ServiceProvider;

class TransformersServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/api.php';
        $this->mergeConfigFrom($configPath, 'api');
    }
}