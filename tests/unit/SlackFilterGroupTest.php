<?php

namespace SLackMessage\Test;

use Orchestra\Testbench\TestCase;
use SlackMessage\Models\SlackFilterGroups;
use SlackMessage\Repository\SlackApiRepository;

class SlackFilterGroupTest extends TestCase
{
    private $channelSlack;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(SlackApiRepository::class);
        $this->client->method('getGroups')
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

        $this->channelSlack = new SlackFilterGroups($this->client);
    }

    public function testFindChannelsBasedOnTheGroupName()
    {
        self::assertCount(1, $this->channelSlack->filter(['#general']));
    }

    public function testReturnEmptyIfTheGroupDoesntExists()
    {
        self::assertCount(0, $this->channelSlack->filter(['#IdoNotExist']));
    }
}
