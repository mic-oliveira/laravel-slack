<?php

namespace SlackMessage\Exceptions;

use Throwable;
use Exception;

class ErrorFetchingGroupsException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Something wen wrong trying to fetch groups list: %s', $message), $code, $previous);
    }
}