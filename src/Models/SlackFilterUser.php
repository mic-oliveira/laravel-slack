<?php

namespace SlackMessage\Models;

use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingUsersException;

/**
 * Class SlackFilterUser.
 */
class SlackFilterUser extends BaseFilter
{

    /**
     * @var
     */
    protected $sanitizeSearchPrefix = '@';

    /**
     * @var string
     */
    protected $filterKeys = 'real_name';

    /**
     * @return Collection
     * @throws ErrorFetchingUsersException
     */
    public function get(): Collection
    {
        return $this->client->getUsers();
    }
}
