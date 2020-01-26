<?php

namespace SlackMessage\Repository;

use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingChannelsException;
use SlackMessage\Exceptions\ErrorFetchingGroupsException;
use SlackMessage\Exceptions\ErrorFetchingUsersException;
use SlackMessage\Exceptions\ErrorPostingMessageException;

interface SlackApi
{

    /**
     * @return Collection
     * @throws ErrorFetchingUsersException
     */
    public function getUsers(): Collection;

    /**
     * @return Collection
     * @throws ErrorFetchingChannelsException
     */
    public function getChannels(): Collection;

    /**
     * @return Collection
     * @throws ErrorFetchingGroupsException
     */
    public function getGroups(): Collection;

    /**
     * @param string $channelId
     * @param string $content
     * @throws ErrorPostingMessageException
     * @return string
     */
   public function post(string $channelId, string $content): string;
}