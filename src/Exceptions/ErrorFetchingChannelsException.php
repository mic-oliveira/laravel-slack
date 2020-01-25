<?php

namespace SlackMessage\Exceptions;

use Exception;

class ErrorFetchingChannelsException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Something wen wrong trying to fetch channels list: %s', $message), $code, $previous);
    }
}