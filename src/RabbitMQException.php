<?php
declare(strict_types=1);
namespace GridCP\RabbitMQ_Client;

final class RabbitMQException extends \AMQPException
{
    public function __construct(string $message)
    {
        parent::__construct("Get failed ->".$message, 401);
    }

}