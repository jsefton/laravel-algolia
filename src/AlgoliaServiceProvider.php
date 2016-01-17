<?php

/*
 * This file is part of Laravel Algolia.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Algolia;

use AlgoliaSearch\Client;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the Algolia service provider class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class AlgoliaServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/algolia.php');

        if ($app instanceof LaravelApplication && $app->runningInConsole()) {
            $this->publishes([$source => config_path('algolia.php')]);
        } elseif ($app instanceof LumenApplication) {
            $app->configure('algolia');
        }

        $this->mergeConfigFrom($source, 'algolia');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory($this->app);
        $this->registerManager($this->app);
        $this->registerBindings($this->app);
    }

    /**
     * Register the factory class.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function registerFactory(Application $app)
    {
        $app->singleton('algolia.factory', function () {
            return new AlgoliaFactory();
        });

        $app->alias('algolia.factory', AlgoliaFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('algolia', function ($app) {
            $config = $app['config'];
            $factory = $app['algolia.factory'];

            return new AlgoliaManager($config, $factory);
        });

        $app->alias('algolia', AlgoliaManager::class);
    }

    /**
     * Register the bindings.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    protected function registerBindings(Application $app)
    {
        $app->bind('algolia.connection', function ($app) {
            $manager = $app['algolia'];

            return $manager->connection();
        });

        $app->alias('algolia.connection', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'algolia',
            'algolia.factory',
            'algolia.connection',
        ];
    }
}
