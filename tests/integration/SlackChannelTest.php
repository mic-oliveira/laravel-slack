<?php

namespace SLackMessage\Test;

use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
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
        $this->app->when([BaseMessage::class])
            ->needs(SlackApi::class)
            ->give(function() {
                return new SlackStub();
            });
        $this->channelSlack = $this->app->make(BaseMessage::class);
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

    public function testShouldSendOneMessageToOneChannel()
    {
        $sendTo = $this->channelSlack->to(['#general'])->send('TESTE');
        self::assertCount(1, $sendTo);
    }

//    public function testShouldSendOneMessageToTwoChannels()
//    {
//        $sendTo = $this->channelSlack->to(['#general', '#random'])->send('TESTE');
//        self::assertCount(2, $sendTo);
//    }
}

class SlackStub implements SlackApi
{

    public function getUsers(): Collection
    {
        return collect();
    }

    public function getChannels(): Collection
    {
        return collect([
            [
                'id' => 'CSR35KWKU',
                'name' => 'general',
                'is_channel' => true,
                'created' => 1579944071,
                'is_archived' => false,
                'is_general' => true,
                'unlinked' => 0,
                'creator' => 'UT3S9SY48',
            ]
        ]);
    }

    public function getGroups(): Collection
    {
        return collect();
    }

    public function post(string $channelId, string $content): string
    {
        return '{ "ok": "true" }';
    }
}
