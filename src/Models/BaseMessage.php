<?php

namespace SlackMessage\Models;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use SlackMessage\Repository\SlackApi;

class BaseMessage
{
    /**
     * @var SlackApi
     */
    private $client;

    /**
     * @var Collection
     */
    private $to;

    /**
     * @param SlackApi $client
     * @throws Exception
     */
    public function __construct(SlackApi $client)
    {
        $this->checkToken();
        $this->client = $client;
    }

    /**
     * @param  array|Collection|string $search
     * @return static
     * @throws BindingResolutionException
     */
    public function to($search): self
    {
        if ($search instanceof Collection) {
            $search = $search->toArray();
        }

        $search = is_array($search) ? $search : func_get_args();

        $this->to = collect([])
            ->concat(app()->make(SlackFilterChannel::class)->filter($search))
            ->concat(app()->make(SlackFilterGroups::class)->filter($search))
            ->concat(app()->make(SlackFilterUser::class)->filter($search));

        return $this;
    }

    /**
     * @param  string $message
     * @return mixed
     */
    public function send(string $message)
    {
        $response = collect();
        $this->to->map(
            function ($channel) use ($message, $response) {
                $post = $this->client->post($channel->id, $message);
                $response->add($post);
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
