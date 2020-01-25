<?php

namespace SlackMessage\Models;

use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingChannelsException;

class SlackFilterChannel extends BaseFilter
{
    /**
     * @var string
     */
    protected $sanitizeSearchPrefix = '#';

    /**
     * @return Collection
     * @throws ErrorFetchingChannelsException
     */
    public function get(): Collection
    {
        return $this->client->getChannels();
    }
}
