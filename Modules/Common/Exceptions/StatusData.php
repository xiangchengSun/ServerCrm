<?php

namespace Modules\Common\Exceptions;

class StatusData
{
    const BAD_REQUEST = 40000;
    const INTERNAL_SERVER_ERROR = 50000;
    const Ok = 20000;

    const PARES_ERROR = 50001;
    const REFLECTION_EXCEPTION = 50002;
    const RUNTIME_EXCEPTION = 50003;
    const ERROR_EXCEPTION = 50004;
    const Error = 50005;
    const BAD_METHOD_CALL_EXCEPTION = 50006;

    const INVALID_ARGUMENT_EXCEPTION = 60000;
    const MODEL_NOT_FOUND_EXCEPTION = 60001;
    const QUERY_EXCEPTION = 60002;

    const TOKEN_ERROR_KEY = 70001;
    const TOKEN_ERROR_SET = 70002;
    const TOKEN_ERROR_BLACK = 70003;
    const TOKEN_ERROR_EXPIRED = 70004;
    const TOKEN_ERROR_JWT = 70005;
    const TOKEN_ERROR_JTB = 70006;
}
