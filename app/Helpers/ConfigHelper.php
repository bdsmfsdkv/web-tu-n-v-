<?php

namespace App\Helpers;

use App\Models\Config;
use Illuminate\Support\Facades\Cache;

class ConfigHelper
{
    /**
     * @var array|null
     */
    protected static ?array $runtimeCache = null;

    /**
     * Nạp toàn bộ config vào memory
     *
     * @return array
     */
    public static function allMap(): array
    {
        if (static::$runtimeCache !== null) {
            return static::$runtimeCache;
        }

        static::$runtimeCache = Cache::remember('runtime_app_configs', 86400, function () {
            return Config::pluck('value', 'key')->all();
        });

        return static::$runtimeCache;
    }

    /**
     * Lấy giá trị cấu hình theo khóa
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $all = static::allMap();
        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        return $default;
    }

    /**
     * Cập nhật hoặc tạo mới cấu hình
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        Config::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        static::clearCache();
    }

    /**
     * Xóa cache cấu hình
     *
     * @return void
     */
    public static function clearCache()
    {
        static::$runtimeCache = null;
        Cache::forget('runtime_app_configs');
        Cache::forget('runtime_service_settings');
    }

    /**
     * Lấy tất cả cấu hình theo tiền tố khóa
     *
     * @param string $prefix
     * @return array
     */
    public static function getByPrefix($prefix)
    {
        if (!empty($prefix) && !str_ends_with($prefix, '.')) {
            $prefix .= '.';
        }

        $all = static::allMap();
        $result = [];

        foreach ($all as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $subKey = substr($key, strlen($prefix));
                $result[$subKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Lấy tất cả cấu hình
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return Config::all();
    }
}

