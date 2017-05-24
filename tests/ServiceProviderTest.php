<?php

/*
 * This file is part of Laravel Algolia.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Jsefton\Tests\Algolia;

use AlgoliaSearch\Client;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use Jsefton\Algolia\AlgoliaFactory;
use Jsefton\Algolia\AlgoliaManager;

/**
 * This is the service provider test class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testAlgoliaFactoryIsInjectable()
    {
        $this->assertIsInjectable(AlgoliaFactory::class);
    }

    public function testAlgoliaManagerIsInjectable()
    {
        $this->assertIsInjectable(AlgoliaManager::class);
    }

    public function testBindings()
    {
        $this->assertIsInjectable(Client::class);

        $original = $this->app['algolia.connection'];
        $this->app['algolia']->reconnect();
        $new = $this->app['algolia.connection'];

        $this->assertNotSame($original, $new);
        $this->assertSame(get_class($original), get_class($new));
    }
}
