<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Mã giảm giá không hợp lệ. Thông báo an toàn để hiển thị cho người dùng.
 */
class DiscountCodeException extends RuntimeException
{
}
