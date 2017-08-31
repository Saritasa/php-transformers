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

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'transformers');
    }
}
