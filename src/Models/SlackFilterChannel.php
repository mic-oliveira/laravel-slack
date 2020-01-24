<?php

namespace SlackMessage\Models;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class SlackFilterChannel.
 */
class SlackFilterChannel extends BaseFilter
{
    /**
     * @var string
     */
    protected $sanitizeSearchPrefix = '#';

    /**
     * SlackFilterChannel constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function get(): Collection
    {
        try {
            return collect(json_decode($this->client->get(config('slack-message.slack_channels_url'))->getBody()->getContents())->channels);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
