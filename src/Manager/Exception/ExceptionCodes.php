<?php
namespace Manager\Exception;

/**
 * interface ExceptionCodes
 * @package Manager\Exception
 */
 
interface ExceptionCodes {
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const MOVED_PERMANENTLY = 301;
    const BAD_REQUEST = 400;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const CONFLICT = 409;
    const TOO_MANY_REQUESTS = 429;
    const INTERNAL_SERVER_ERROR = 500;
    const OPERATION_FAILED = 520;
    const NO_RESPONSE     = 70500;
}