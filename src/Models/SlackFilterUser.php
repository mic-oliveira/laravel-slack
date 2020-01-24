<?php


namespace SlackMessage\Models;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class SlackFilterUser
 *
 * @package SlackMessage\Models
 */
class SlackFilterUser extends BaseFilter
{
    /**
     * @var
     */
    protected $sanitizeSearchPrefix ='@';

    /**
     * @var string
     */
    protected $filterKeys = 'real_name';

    /**
     * SlackFilterUser constructor.
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
    public function get():Collection
    {
        try {
            return collect(json_decode($this->client->get(config('slack-message.slack_users_url'))->getBody()->getContents())->members);
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

}
