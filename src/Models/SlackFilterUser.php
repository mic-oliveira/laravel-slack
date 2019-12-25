<?php


namespace SlackMessage\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class SlackFilterUser extends BaseFilter
{
    /**
     * SlackFilterUser constructor.
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
        return collect(json_decode($this->client->get(config('slack-message.slack_users_url'))->getBody()->getContents())->members);
    }

    /**
     * @param array $array
     * @return Collection
     */
    public function filter($array = [])
    {
        $user = collect($array)->map(function($user) {
            if($user[0] ==='@'){
                return str_replace('@','',$user);
            }
        });
        $list = $this->get();
        return $list->whereIn('real_name',$user->filter()->toArray());
    }


}
