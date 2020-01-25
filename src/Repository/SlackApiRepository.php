<?php

namespace SlackMessage\Repository;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingUsersException;
use Exception;

class SlackApiRepository implements SlackApi
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Collection
     * @throws ErrorFetchingUsersException
     */
    public function getUsers(): Collection
    {
        $getUsers = $this->client->get(config('slack-message.slack_users_url'));
        $response = $getUsers->getBody()->getContents();

        try {
            return collect(json_decode($response)->members);
        } catch (Exception $exception) {
            throw new ErrorFetchingUsersException(sprintf('%s', $response));
        }
    }

}