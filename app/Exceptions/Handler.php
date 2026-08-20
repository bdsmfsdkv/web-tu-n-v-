<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
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
     * Prevent the default Laravel 419 "Page Expired" screen.
     * Normal form requests are redirected back to the previous page so a fresh
     * CSRF token/session is generated. AJAX requests keep status 419 so the
     * frontend can detect it and reload the page automatically.
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            return $this->expiredSessionResponse($request);
        }

        $response = parent::render($request, $e);

        if (method_exists($response, 'getStatusCode') && $response->getStatusCode() === 419) {
            return $this->expiredSessionResponse($request);
        }

        return $response;
    }

    protected function expiredSessionResponse($request)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'reload' => true,
                'message' => 'Phiên làm việc đã hết hạn. Trang sẽ tự tải lại.',
            ], 419);
        }

        $target = $request->headers->get('referer') ?: url('/');

        return redirect()
            ->to($target)
            ->withInput($request->except($this->dontFlash))
            ->with('warning', 'Phiên làm việc đã hết hạn. Trang đã được tải lại, vui lòng thử lại.');
    }
}
