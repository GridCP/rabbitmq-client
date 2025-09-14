<?php
declare(strict_types=1);
namespace GridCP\RabbitMQ_Client\Tests;

use GridCP\RabbitMQ_Client\Exchange;
use GridCP\RabbitMQ_Client\GClient;
use PHPUnit\Framework\TestCase;

class GClientTest extends TestCase
{
    private GClient $client;

    public function setUp(): void{
        $this->client = new GClient($_ENV['HOST'],$_ENV['PORT'],$_ENV['USERNAME'],$_ENV['PASSWORD'],$_ENV['VHOST']);
        $this->client->createConnection("prueba");
    }


    public function testExchange():void
    {

        $exchange = new Exchange($this->client->getConnection());
        $exchange("prueba","direct", true,true, true, true, true, null);
    }

    public function testSendMessage():void
    {
        $this->client->publicMessage("prueba","amq.direct","gridcp_rabbitmq","{prueba}");
    }

}