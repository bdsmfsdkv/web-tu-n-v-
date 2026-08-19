<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Language;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session or default language
        $locale = session('locale');
        
        if (!$locale) {
            // Get default language - ưu tiên Vietnamese
            $defaultLanguage = Language::where('is_default', true)->where('is_active', true)->first();
            
            if ($defaultLanguage) {
                $locale = $defaultLanguage->iso_code;
            } else {
                // Nếu không có default language, kiểm tra xem có Vietnamese không
                $vietnamese = Language::where('iso_code', 'vi')->where('is_active', true)->first();
                if ($vietnamese) {
                    // Set Vietnamese làm default nếu chưa có default
                    $vietnamese->is_default = true;
                    $vietnamese->save();
                    $locale = 'vi';
                } else {
                    $locale = config('app.locale', 'vi');
                }
            }
        } else {
            // Nếu session có locale, kiểm tra xem ngôn ngữ đó có tồn tại và active không
            $language = Language::where('iso_code', $locale)->where('is_active', true)->first();
            if (!$language) {
                // Nếu ngôn ngữ trong session không tồn tại hoặc không active, dùng default
                $defaultLanguage = Language::where('is_default', true)->where('is_active', true)->first();
                if ($defaultLanguage) {
                    $locale = $defaultLanguage->iso_code;
                } else {
                    $locale = 'vi'; // Fallback về Vietnamese
                }
                // Update session với locale mới
                session(['locale' => $locale]);
            }
        }

        // Set locale
        app()->setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}
