<?php


namespace SlackMessage\Models;


use GuzzleHttp\Client;
use Illuminate\Support\Collection;

abstract class BaseFilter
{
    protected $client;

    /**
     * BaseFilter constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    abstract function get():Collection;

    /**
     * @param array $array
     * @return Collection
     */
    public function filter($array = [])
    {
        $channels = collect($array)->map(function($channel) {
            if($channel[0] ==='#'){
                return str_replace('#','',$channel);
            }
        });
        $list = $this->get();
        return $list->whereIn('name', $channels);
    }

}
