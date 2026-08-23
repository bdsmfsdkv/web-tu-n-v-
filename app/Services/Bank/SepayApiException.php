<?php

namespace App\Services\Bank;

use RuntimeException;

/**
 * Lỗi khi gọi SePay API. Message của exception này luôn an toàn để log
 * (không bao giờ chứa token hoặc Authorization header).
 */
class SepayApiException extends RuntimeException
{
    protected ?int $httpStatus;

    public function __construct(string $message, ?int $httpStatus = null)
    {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
    }

    public function httpStatus(): ?int
    {
        return $this->httpStatus;
    }
}
