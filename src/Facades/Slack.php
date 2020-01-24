<?php

namespace SlackMessage\Facades;

use Illuminate\Support\Facades\Facade;
use SlackMessage\Models\BaseMessage as Slacker;

/**
 * Class Slack.
 */
class Slack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Slacker::class;
    }
}
