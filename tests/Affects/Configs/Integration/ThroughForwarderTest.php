<?php

namespace Tenancy\Tests\Affects\Configs\Integration;

use Tenancy\Affects\Configs\Provider;
use Tenancy\Facades\Tenancy;
use Tenancy\Tests\Affects\AffectsIntegrationTestCase;
use Tenancy\Tests\Affects\Configs\ThroughForwarder;

class ThroughForwarderTest extends AffectsIntegrationTestCase
{
    use ThroughForwarder;

    protected $additionalProviders = [Provider::class];

    /** @test */
    public function by_default_the_helper_result_has_no_value()
    {
        $this->assertNull(config('testing.tenant'));
    }

    /** @test */
    public function it_changes_the_result_of_the_helper()
    {
        Tenancy::setTenant($this->tenant);

        $this->assertEquals(
            $this->tenant->getTenantKey(),
            config('testing.tenant')
        );
    }
}
