<?php declare(strict_types=1);

/*
 * This file is part of the tenancy/tenancy package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see http://laravel-tenancy.com
 * @see https://github.com/tenancy
 */

namespace Tenancy\Tests\Affects\URL;

use Tenancy\Facades\Tenancy;
use Tenancy\Testing\TestCase;
use Tenancy\Testing\Mocks\Tenant;
use Illuminate\Support\Facades\URL;
use Tenancy\Affects\URL\Events\ConfigureURL;
use Tenancy\Affects\URL\Providers\ServiceProvider;

class ConfiguresURLTest extends TestCase
{
    protected $additionalProviders = [ServiceProvider::class];

    /**
     * @var Tenant
     */
    protected $tenant;

    protected function afterSetUp()
    {
        $this->tenant = $this->mockTenant();
    }

    /**
     * @test
     */
    public function can_set_url()
    {
        $this->events->listen(ConfigureURL::class, function (ConfigureURL $event) {
            $event->changeRoot('tenant.test');
        });

        Tenancy::setTenant($this->tenant);

        $this->assertEquals(
            'tenant.test',
            URL::current()
        );
    }

    /**
     * @test
     */
    public function forwards_to_url_generator()
    {
        $this->events->listen(ConfigureURL::class, function (ConfigureURL $event) {
            $event->forceRootUrl('tenant.test');
        });

        Tenancy::setTenant($this->tenant);

        $this->assertEquals(
            'tenant.test',
            URL::current()
        );
    }
}
