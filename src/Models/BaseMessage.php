<?php

namespace SlackMessage\Models;

use GuzzleHttp\Client;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Nullable;

/**
 * Class BaseMessage
 * @package SlackMessage\Models
 */
class BaseMessage
{
    private $client;
    private $to;
    private static $instance;

    /**
     * BaseMessage constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        self::$instance = $this;
    }

    /**
     * @param array $channels
     * @return static
     * @throws BindingResolutionException
     */
    static public function to(array $channels=[]): self
    {
        //dd($channels);
        if(is_null(self::$instance)) {
            self::$instance = app()->make(BaseMessage::class);
        }
        self::$instance->to = app()->make(SlackFilterChannel::class)->filter($channels)
            ->concat((app()->make(SlackFilterUser::class)->filter($channels)));
        return self::$instance;
    }

    public function setUser($user_token)
    {

    }

    /**
     * @param string $message
     * @return mixed
     */
    public function send(string $message)
    {
        $response = collect();
        $this->to->map(function ($channel) use ($message,$response) {
            $json = [
                'channel'   =>  $channel->id,
                'text'      =>  $message
            ];
            $response->add($this->client->post(config('slack-message.slack_post_message'),
                [
                    'headers'   =>  [
                        'Accept'        =>  'application/json',
                        'Content-Type'  =>  'application/json'
                    ],
                    'json' => $json
                ]));
        });
        return $response;
    }

}
