<?php

namespace Tests\Unit;

use App\Mail\TestMail;
use Tests\TestCase;

class TestMailLogoUrlTest extends TestCase
{
    public function test_it_normalizes_public_email_logo_urls(): void
    {
        $this->app['env'] = 'production';

        $this->assertSame(
            'https://domain.com/storage/config/a.png',
            TestMail::emailLogoUrl('/storage/config/a.png', 'http://domain.com')
        );
        $this->assertSame(
            'https://domain.com/storage/config/a.png',
            TestMail::emailLogoUrl('storage/config/a.png', 'https://domain.com/')
        );
        $this->assertSame(
            'https://cdn.domain.com/a.png',
            TestMail::emailLogoUrl('https://cdn.domain.com/a.png', 'https://domain.com')
        );
        $this->assertNull(TestMail::emailLogoUrl('', 'https://domain.com'));
        $this->assertNull(TestMail::emailLogoUrl(null, 'https://domain.com'));
        $this->assertNull(TestMail::emailLogoUrl('/storage/config/a.png', 'http://localhost'));
    }
}
