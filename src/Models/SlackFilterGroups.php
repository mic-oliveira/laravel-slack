<?php

namespace SlackMessage\Models;

use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingGroupsException;

class SlackFilterGroups extends BaseFilter
{
    /**
     * @var string
     */
    protected $sanitizeSearchPrefix = '#';

    /**
     * @return Collection
     * @throws ErrorFetchingGroupsException
     */
    public function get(): Collection
    {
        return $this->client->getGroups();
    }
}
