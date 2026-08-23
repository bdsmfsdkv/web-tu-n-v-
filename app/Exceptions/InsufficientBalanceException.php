<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Số dư (tiền/vàng/ngọc) không đủ để thực hiện giao dịch.
 *
 * Thông báo của exception này an toàn để hiển thị trực tiếp cho người dùng.
 */
class InsufficientBalanceException extends RuntimeException
{
    public function __construct(string $message = 'Số dư không đủ để thực hiện giao dịch.')
    {
        parent::__construct($message);
    }
}
