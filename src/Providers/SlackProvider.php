<?php

namespace SlackMessage\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use SlackMessage\Facades\Slack;
use SlackMessage\Models\BaseFilter;
use SlackMessage\Models\BaseMessage;
use SlackMessage\Models\SlackFilterChannel;
use SlackMessage\Models\SlackFilterGroups;
use SlackMessage\Models\SlackFilterUser;
use SlackMessage\Repository\SlackApi;
use SlackMessage\Repository\SlackApiRepository;

/**
 * Class SlackProvider.
 */
class SlackProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $path;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->path = __DIR__ . '/../../config/slack-message.php';
        parent::__construct($app);
    }

    public function boot()
    {
        $this->publishes(
            [
                realpath($this->path) => config_path('slack-message.php'),
            ],
            'config'
        );
    }

    public function register()
    {
        $this->mergeConfigFrom(realpath($this->path), 'slack-message');
        app()->when(
            [
                BaseFilter::class,
                SlackFilterChannel::class,
                SlackFilterGroups::class,
                SlackFilterUser::class,
                BaseMessage::class,
            ]
        )->needs(SlackApi::class)
            ->give(
                function () {
                    return new SlackApiRepository(
                        new Client(
                            [
                                'base_uri' => config('slack-message.slack_api_url'),
                                'headers'   =>  [
                                    'Authorization' =>  'Bearer '.config('slack-message.slack_bot_token'),
                                    'Accept'        =>  'application/json',
                                    'Content-type'  =>  'application/json'
                                ],
                                'verify'    =>  false,
                            ]
                        )
                    );
                }
            );
        $this->app->alias(Slack::class, 'slack');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Slack::class];
    }
}
