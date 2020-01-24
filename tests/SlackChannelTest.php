<?php

namespace SLackMessage\Test;

use Illuminate\Contracts\Container\BindingResolutionException;
use Orchestra\Testbench\TestCase;
use SlackMessage\Models\BaseMessage;
use SlackMessage\Providers\SlackProvider;

class SlackChannelTest extends TestCase
{
    private $channelSlack;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->channelSlack = app()->make(BaseMessage::class);
    }

    /**
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SlackProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app); // TODO: Change the autogenerated stub
    }

    /**
     * @throws BindingResolutionException
     */
    public function testSend()
    {
        dump(BaseMessage::to(['#geral', '#outros-assuntos', '#academiafrontend', '@Michael de Oliveira Ferreira'])->send('TESTE'));
        self::assertTrue(true);
    }
}
