<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use PDOException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\RequestEntityTooLargeHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'token',
        'access_token',
        'api_token',
        'secret',
        'pin',
        'serial',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            return $this->expiredSessionResponse($request);
        }

        if ($e instanceof \Illuminate\Http\Exceptions\PostTooLargeException || $e instanceof RequestEntityTooLargeHttpException) {
            return back()->withInput()->withErrors([
                'upload' => 'Tổng dung lượng ảnh vượt giới hạn máy chủ (' . ini_get('post_max_size') . '). Hãy giảm kích thước ảnh rồi tải lại.',
            ]);
        }

        // Redirect 404 / missing models to home for web requests (except admin / api / ajax)
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException || $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            if (!$request->expectsJson() && !$request->is('api/*') && !$request->ajax()) {
                if (!$request->is('admin*')) {
                    return redirect()->route('home');
                }
            }
        }

        // Hardened production handling for database and fatal infrastructure exceptions
        if (!config('app.debug')) {
            if ($e instanceof QueryException || $e instanceof PDOException) {
                if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
                    ], 500);
                }

                return response()->view('errors.500', [], 500);
            }
        }

        $response = parent::render($request, $e);

        if (method_exists($response, 'getStatusCode')) {
            $status = $response->getStatusCode();
            if ($status === 419) {
                return $this->expiredSessionResponse($request);
            }
            if ($status === 404 && !$request->expectsJson() && !$request->is('api/*') && !$request->ajax() && !$request->is('admin*')) {
                return redirect()->route('home');
            }
        }

        return $response;
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->ajax() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để tiếp tục.',
                'redirect' => route('login'),
            ], 401);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    protected function expiredSessionResponse($request)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'reload' => true,
                'redirect' => auth()->check() ? url('/') : route('login'),
            ], 419);
        }

        $target = auth()->check() ? url('/') : route('login');

        return redirect()->to($target);
    }
}
