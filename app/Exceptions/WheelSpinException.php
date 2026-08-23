<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Lỗi quay vòng quay có thông báo an toàn để hiển thị trực tiếp cho người chơi
 * (ví dụ hết kho tài khoản thưởng, cấu hình ô thưởng sai).
 */
class WheelSpinException extends RuntimeException
{
}
