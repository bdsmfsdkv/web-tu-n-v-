<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Change language
     */
    public function change(Request $request)
    {
        $request->validate([
            'iso_code' => 'required|exists:languages,iso_code',
        ]);

        $language = Language::where('iso_code', $request->iso_code)->where('is_active', true)->first();

        if (!$language) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ngôn ngữ không tồn tại hoặc đã bị ẩn!',
                ], 404);
            }
            return back()->with('error', 'Ngôn ngữ không tồn tại hoặc đã bị ẩn!');
        }

        // Store language in session
        session(['locale' => $language->iso_code]);
        app()->setLocale($language->iso_code);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Đổi ngôn ngữ thành công!',
                'language_name' => $language->name,
                'redirect' => $request->input('redirect') ?? url('/'),
            ]);
        }

        return redirect($request->input('redirect') ?? url('/'))->with('success', 'Đổi ngôn ngữ thành công!');
    }

    /**
     * Get available languages
     */
    public function getLanguages()
    {
        $languages = Language::where('is_active', true)->orderBy('order')->get(['id', 'name', 'iso_code', 'flag_path']);

        return response()->json([
            'status' => 'success',
            'languages' => $languages,
        ]);
    }
}
