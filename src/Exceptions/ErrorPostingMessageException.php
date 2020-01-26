<?php

namespace SlackMessage\Exceptions;

use Exception;
use Throwable;

class ErrorPostingMessageException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Something wen wrong trying to post a message: %s', $message), $code, $previous);
    }
}
