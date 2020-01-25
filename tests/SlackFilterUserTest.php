<?php

namespace SLackMessage\Test;

use Orchestra\Testbench\TestCase;
use SlackMessage\Models\SlackFilterUser;
use SlackMessage\Repository\SlackApiRepository;

class SlackFilterUserTest extends TestCase
{
    private $channelSlack;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(SlackApiRepository::class);
        $this->client->method('getUsers')
            ->willReturn(collect([
                [
                    'id' => 'USLACKBOT',
                    'team_id' => 'TT5NAGNKH',
                    'name' => 'slackbot',
                    'deleted' => false,
                ],
                [
                    'id' => 'USLACKBOT',
                    'team_id' => 'TT5NAGNKH',
                    'name' => 'Michael',
                    'deleted' => false,
                ],
            ]));

        $this->channelSlack = new SlackFilterUser($this->client);
    }

    public function testFindTheUserBasedOnTheUserName()
    {
        self::assertCount(1, $this->channelSlack->filter(['@Michael']));
    }

    public function testReturnEmptyIfTheUsernameDoesntExists()
    {
        self::assertCount(0, $this->channelSlack->filter(['@IdoNotExist']));
    }
}
