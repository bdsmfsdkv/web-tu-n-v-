<?php

namespace Tests\Feature;

use App\Exceptions\Handler;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;
use Tests\TestCase;

class ProductionErrorHandlingTest extends TestCase
{
    public function test_database_query_exception_returns_clean_500_page_when_debug_false(): void
    {
        config(['app.debug' => false]);

        $handler = app(Handler::class);
        $request = Request::create('/', 'GET');
        $queryException = new QueryException(
            'mysql',
            'SELECT * FROM secret_table WHERE password = "secret_db_pass"',
            [],
            new \Exception('SQLSTATE[HY000] [1045] Access denied for user "forge"@"localhost"')
        );

        $response = $handler->render($request, $queryException);

        $this->assertEquals(500, $response->getStatusCode());
        $content = $response->getContent();

        $this->assertStringNotContainsString('SQLSTATE', $content);
        $this->assertStringNotContainsString('QueryException', $content);
        $this->assertStringNotContainsString('secret_table', $content);
        $this->assertStringNotContainsString('secret_db_pass', $content);
        $this->assertStringNotContainsString('forge', $content);
        $this->assertStringNotContainsString('stack trace', strtolower($content));
        $this->assertStringContainsString('Hệ thống đang gặp sự cố', $content);
    }

    public function test_database_pdo_exception_returns_clean_json_for_api_when_debug_false(): void
    {
        config(['app.debug' => false]);

        $handler = app(Handler::class);
        $request = Request::create('/api/some-endpoint', 'GET');
        $request->headers->set('Accept', 'application/json');

        $pdoException = new PDOException('SQLSTATE[HY000] [2002] Connection refused to 127.0.0.1:3306 with password forge');

        $response = $handler->render($request, $pdoException);

        $this->assertEquals(500, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);

        $this->assertIsArray($data);
        $this->assertFalse($data['success']);
        $this->assertEquals('Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.', $data['message']);
        $this->assertArrayNotHasKey('exception', $data);
        $this->assertArrayNotHasKey('trace', $data);
    }

    public function test_health_check_endpoint_returns_safe_status(): void
    {
        $response = $this->getJson('/api/health');

        $this->assertContains($response->getStatusCode(), [200, 503]);
        $data = $response->json();
        $this->assertArrayHasKey('status', $data);
        $this->assertContains($data['status'], ['ok', 'degraded']);
        $this->assertArrayNotHasKey('message', $data);
        $this->assertArrayNotHasKey('exception', $data);
    }

    public function test_config_database_has_no_forge_fallbacks(): void
    {
        $connections = config('database.connections');

        $this->assertNotEquals('forge', $connections['mysql']['database'] ?? null);
        $this->assertNotEquals('forge', $connections['mysql']['username'] ?? null);
    }
}
