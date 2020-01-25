<?php

namespace SlackMessage\Repository;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingChannelsException;
use SlackMessage\Exceptions\ErrorFetchingGroupsException;
use SlackMessage\Exceptions\ErrorFetchingUsersException;
use Exception;

class SlackApiRepository implements SlackApi
{
    private $client;
    private $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->token = ['token' => config('slack-message.slack_bot_token')];
    }

    /**
     * @return Collection
     * @throws ErrorFetchingUsersException
     */
    public function getUsers(): Collection
    {
        $getUsers = $this->client->get(config('slack-message.slack_users_url', $this->token));
        $response = $getUsers->getBody()->getContents();

        try {
            return collect(json_decode($response)->members);
        } catch (Exception $exception) {
            throw new ErrorFetchingUsersException(sprintf('%s', $response));
        }
    }

    /**
     * @return Collection
     * @throws ErrorFetchingChannelsException
     */
    public function getChannels(): Collection
    {
        $getChannels = config('slack-message.slack_channels_url');
        $response = $this->client->get($getChannels, $this->token)->getBody()->getContents();

        try {
            return collect(json_decode($response)->channels);
        } catch (Exception $exception) {
            throw new ErrorFetchingChannelsException(sprintf('%s', $response));
        }
    }

    /**
     * @return Collection
     * @throws ErrorFetchingGroupsException
     */
    public function getGroups(): Collection
    {
        $getGroups = config('slack-message.slack_groups_url');
        $response = $this->client->get($getGroups, $this->token)->getBody()->getContents();

        try {
            return collect(json_decode($response)->groups);
        } catch (Exception $exception) {
            throw new ErrorFetchingGroupsException($exception->getMessage());
        }
    }

    /**
     * @param string $channelId
     * @param string $content
     * @return string
     */
   public function post(string $channelId, string $content): string
   {
       $url = config('slack-message.slack_post_message');
       $data = [
           'channel'   => $channelId,
           'text'      => $content,
           'token'     => $this->token['token'],
       ];
       return $this->client->post(
           $url,
           [
               'headers'   =>  [
                   'Accept'        =>  'application/json',
                   'Content-Type'  =>  'application/json',
               ],
               'json' => $data,
           ]
       )->getBody()->getContents();
   }
}