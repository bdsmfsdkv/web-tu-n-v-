<?php

namespace Tests\Unit;

use App\Helpers\ConfigHelper;
use Tests\TestCase;

class ConfigAndPerformanceTest extends TestCase
{
    public function test_config_helper_runtime_cache(): void
    {
        ConfigHelper::clearCache();
        $siteName = config_get('site_name', 'DefaultSite');
        $this->assertNotNull($siteName);

        $map = ConfigHelper::allMap();
        $this->assertIsArray($map);
    }
}
