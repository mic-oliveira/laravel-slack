<?php

namespace SLackMessage\Test;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use SlackMessage\Models\BaseMessage;
use SlackMessage\Providers\SlackProvider;
use SlackMessage\Repository\SlackApi;

class SlackChannelTest extends TestCase
{
    private $channelSlack;

    protected function setUp(): void
    {
        parent::setUp();

        $client = $this->createMock(SlackApi::class);

        $this->channelSlack = new BaseMessage($client);
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SlackProvider::class,
        ];
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
    }

    public function testSend()
    {
        $this->channelSlack->to(['#general'])->send('TESTE');
        self::assertTrue(true);
    }
}
