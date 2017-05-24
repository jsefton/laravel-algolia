<?php

/*
 * This file is part of Laravel Algolia.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Jsefton\Tests\Algolia\Facades;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use Jsefton\Algolia\AlgoliaManager;
use Jsefton\Algolia\Facades\Algolia;
use Jsefton\Tests\Algolia\AbstractTestCase;

/**
 * This is the Algolia facade test class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class AlgoliaTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'algolia';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return Algolia::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return AlgoliaManager::class;
    }
}
