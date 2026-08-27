<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadHelper
{
    /**
     * Đảm bảo thư mục tồn tại với quyền 0755
     *
     * @param string $path Đường dẫn thư mục
     * @return string Đường dẫn đầy đủ của thư mục
     */
    public static function ensureDirectoryExists(string $path): string
    {
        try {
            $fullPath = Storage::path($path);
        } catch (\Throwable $e) {
            $fullPath = storage_path('app/' . ltrim($path, '/'));
        }

        if (!file_exists($fullPath)) {
            // Lưu umask hiện tại
            $oldUmask = umask(0);

            // Tạo thư mục với quyền 0755
            @mkdir($fullPath, 0755, true);

            // Khôi phục umask ban đầu
            umask($oldUmask);
        }

        return $fullPath;
    }

    /**
     * Upload một file và trả về URL công khai
     *
     * @param UploadedFile $file File cần upload
     * @param string $directory Thư mục lưu trữ
     * @param string|null $filename Tên file tùy chọn
     * @param bool $preserveFilename Có giữ nguyên tên file gốc không
     * @return string URL công khai của file
     */
    public static function upload(UploadedFile $file, string $directory, ?string $filename = null, bool $preserveFilename = false): string
    {
        try {
            // Đảm bảo thư mục tồn tại với quyền 0755
            self::ensureDirectoryExists('public/' . $directory);

            // Kiểm tra PHP fileinfo extension cho an toàn môi trường
            if (!class_exists('finfo') && !extension_loaded('fileinfo')) {
                Log::warning('PHP extension "fileinfo" (finfo) is not enabled in this runtime environment.');
            }

            // Tạo tên file nếu không được chỉ định
            if (!$filename) {
                $ext = $file->getClientOriginalExtension();
                if (empty($ext)) {
                    $ext = $file->guessExtension() ?: 'bin';
                }
                if ($preserveFilename) {
                    $filename = $file->getClientOriginalName();
                } else {
                    $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $ext;
                }
            }

            // Upload file
            $path = $file->storeAs('public/' . $directory, $filename);

            return Storage::url($path);
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), 'finfo') || !class_exists('finfo')) {
                Log::error('Upload failed due to missing PHP fileinfo extension: ' . $e->getMessage());
                throw new \RuntimeException('Máy chủ Hosting cPanel chưa bật extension PHP "fileinfo" (finfo). Vui lòng vào cPanel > Select PHP Version > Extensions > Tích chọn "fileinfo".', 0, $e);
            }
            Log::error('Error uploading file: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload nhiều file và trả về mảng URL công khai
     *
     * @param array $files Mảng các file cần upload
     * @param string $directory Thư mục lưu trữ
     * @return array Mảng URL công khai của các file
     */
    public static function uploadMultiple(array $files, string $directory): array
    {
        $urls = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $urls[] = self::upload($file, $directory);
            }
        }

        return $urls;
    }

    /**
     * Xóa file dựa trên URL công khai
     *
     * @param string $url URL công khai của file
     * @return bool Kết quả xóa file
     */
    public static function deleteByUrl(string $url): bool
    {
        try {
            if (empty($url)) {
                return false;
            }
            // Không xóa URL bên ngoài (http://, https://)
            if (preg_match('/^https?:\/\//i', $url) && !str_contains($url, '/storage/')) {
                return false;
            }
            $parsedPath = parse_url($url, PHP_URL_PATH) ?? $url;
            $path = str_replace('/storage/', '', $parsedPath);
            $path = ltrim($path, '/');
            if (str_starts_with($path, 'storage/')) {
                $path = substr($path, 8);
            }

            $deleted = false;

            // Thử xóa qua Storage facade nếu finfo có sẵn
            try {
                $deletedPublic = Storage::disk('public')->delete($path);
                $deletedRoot = Storage::delete('public/' . $path);
                $deleted = $deletedPublic || $deletedRoot;
            } catch (\Throwable $e) {
                // Fallback nếu Storage driver lỗi (ví dụ thiếu finfo)
                $directPath = storage_path('app/public/' . $path);
                if (file_exists($directPath)) {
                    $deleted = @unlink($directPath);
                }
            }

            return $deleted;
        } catch (\Throwable $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return false;
        }
    }
}