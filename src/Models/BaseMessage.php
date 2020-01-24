<?php

namespace SlackMessage\Models;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

/**
 * Class BaseMessage.
 */
class BaseMessage
{
    /**
     * @var Client
     */
    private $client;
    private $to;
    private static $instance;

    /**
     * BaseMessage constructor.
     *
     * @param  Client $client
     * @throws Exception
     */
    public function __construct(Client $client)
    {
        $this->checkToken();
        $this->client = $client;
        self::$instance = $this;
    }

    /**
     * @param  array|Collection|string $search
     * @return static
     * @throws BindingResolutionException
     */
    public static function to($search): self
    {
        if ($search instanceof Collection) {
            $search = $search->toArray();
        }

        $search = is_array($search) ? $search : func_get_args();

        if (is_null(self::$instance)) {
            self::$instance = app()->make(self::class);
        }
        //TODO: melhorar filtros
        self::$instance->to = collect([])
            ->concat(app()->make(SlackFilterChannel::class)->filter($search))
            ->concat(app()->make(SlackFilterGroups::class)->filter($search))
            ->concat(app()->make(SlackFilterUser::class)->filter($search));

        return self::$instance;
    }

    /**
     * @param  string $message
     * @return mixed
     */
    public function send(string $message)
    {
        $response = collect();
        $this->to->map(
            function ($channel) use ($message,$response) {
                $json = [
                    'channel'   =>  $channel->id,
                    'text'      =>  $message,
                ];
                $response->add(
                    $this->client->post(
                        config('slack-message.slack_post_message'),
                        [
                            'headers'   =>  [
                                'Accept'        =>  'application/json',
                                'Content-Type'  =>  'application/json',
                            ],
                            'json' => $json,
                        ]
                    )
                );
            }
        );

        return $response;
    }

    /**
     * @throws Exception
     */
    protected function checkToken()
    {
        if (! config('slack-message.slack_bot_token')) {
            throw new Exception('Please set you slack token into config or env');
        }
    }
}
