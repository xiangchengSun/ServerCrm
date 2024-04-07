<?php

namespace Modules\Common\Exceptions;

use Throwable;

class ApiException extends \Exception
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $errors;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     */
    public function __construct(array $apiErrConst, Throwable $previous = null)
    {
        parent::__construct($apiErrConst['message'], $apiErrConst['status'], $previous);
    }
}
