<?php

namespace App\Helpers;

use Illuminate\Support\Str;

/**
 * Tìm preset thuộc tính game theo slug danh mục / nhóm game.
 *
 * Logic này trước đây là một Closure nằm trong config/game_attributes.php, khiến
 * `php artisan config:cache` thất bại (Closure không serialize được) và toàn bộ
 * file config phải parse lại từ disk ở mỗi request.
 */
class GamePresetHelper
{
    public static function resolve(?string $identifier): ?string
    {
        if ($identifier === null || $identifier === '') {
            return null;
        }

        $identifier = Str::slug($identifier);
        if ($identifier === '') {
            return null;
        }

        foreach (config('game_attributes.games', []) as $key => $game) {
            if ($key === $identifier) {
                return $key;
            }

            $aliases = $game['aliases'] ?? [];
            if (in_array($identifier, $aliases, true)) {
                return $key;
            }

            foreach ($aliases as $alias) {
                if (str_contains($identifier, $alias) || str_contains($alias, $identifier)) {
                    return $key;
                }
            }
        }

        return null;
    }
}
