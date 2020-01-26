<?php

namespace SLackMessage\Test;

use Orchestra\Testbench\TestCase;
use SlackMessage\Models\SlackFilterChannel;
use SlackMessage\Repository\SlackApi;

class SlackFilterChannelTest extends TestCase
{
    private $channelSlack;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(SlackApi::class);
        $this->client->method('getChannels')
            ->willReturn(collect([
                [
                    'id' => 'CSR35KWKU',
                    'name' => 'general',
                    'is_channel' => true,
                    'created' => 1579944071,
                    'is_archived' => false,
                    'is_general' => true,
                    'unlinked' => 0,
                    'creator' => 'UT3S9SY48',
                ],
                [
                    'id' => 'CSR9999',
                    'name' => 'pokemon',
                    'is_channel' => true,
                    'created' => 1579944022,
                    'is_archived' => false,
                    'is_general' => true,
                    'unlinked' => 0,
                    'creator' => 'UT3S',
                ],
            ]));

        $this->channelSlack = new SlackFilterChannel($this->client);
    }

    public function testFindChannelsBasedOnTheChannelName()
    {
        self::assertCount(1, $this->channelSlack->filter(['#general']));
    }

    public function testFindTwoChannels()
    {
        self::assertCount(2, $this->channelSlack->filter(['#general', '#pokemon']));
    }

    public function testReturnEmptyIfTheChannelDoesntExists()
    {
        self::assertCount(0, $this->channelSlack->filter(['#IdoNotExist']));
    }
}
