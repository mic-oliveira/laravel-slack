<?php


namespace SlackMessage\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class SlackFilterChannel extends BaseFilter
{
    /**
     * SlackFilterChannel constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * @return Collection
     */
    public function get():Collection
    {
        return collect(\GuzzleHttp\json_decode($this->client->get(config('slack-message.slack_channels_url'))->getBody()->getContents())->channels);
    }

}
