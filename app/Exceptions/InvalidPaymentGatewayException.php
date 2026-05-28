<?php
declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidPaymentGatewayException extends HttpException
{
    public function __construct(int $code, string $message)
    {
        parent::__construct($code, $message);
    }
}
