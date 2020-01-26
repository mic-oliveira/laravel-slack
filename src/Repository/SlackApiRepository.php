<?php

namespace SlackMessage\Repository;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use SlackMessage\Exceptions\ErrorFetchingChannelsException;
use SlackMessage\Exceptions\ErrorFetchingGroupsException;
use SlackMessage\Exceptions\ErrorFetchingUsersException;
use Exception;
use SlackMessage\Exceptions\ErrorPostingMessageException;

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
            $members = json_decode($response, true);
            return collect($members['members']);
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
            $channels = json_decode($response, true);
            return collect($channels['channels']);
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
            $groups = json_decode($response, true);
            return collect($groups['groups']);
        } catch (Exception $exception) {
            throw new ErrorFetchingGroupsException($exception->getMessage());
        }
    }

    /**
     * @param string $channelId
     * @param string $content
     * @return string
     * @throws ErrorPostingMessageException
     */
   public function post(string $channelId, string $content): string
   {
       $url = config('slack-message.slack_post_message_url');
       $data = [
           'channel'   => $channelId,
           'text'      => $content,
           'token'     => $this->token['token'],
       ];

       $response = $this->client->post(
           $url,
           [
               'headers' => [
                   'Accept' => 'application/json',
                   'Content-Type' => 'application/json',
               ],
               'json' => $data,
           ]
       );

       $content = $response->getBody()->getContents();

       if ($response->getStatusCode() !== 200) {
           throw new ErrorPostingMessageException($content);
       }

       if (!json_decode($content)->ok) {
           throw new ErrorPostingMessageException($content);
       }

       return $content;
   }
}