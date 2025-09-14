<?php
declare(strict_types=1);
namespace GridCP\RabbitMQ_Client;

class GClient
{

    private Connection $connection;

    public function __construct(string $host, string $port, string $user, string $password, string $vhost)
    {
        $this->connection = new Connection($host, $port, $user, $password, $vhost);
    }

    public function createConnection(string $queue)
    {
        $this->connection->connect($queue);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
    public function createExchange(?string $name, ?string $type, ?bool $passive, ?bool $durable, ?bool $auto_delete,?bool $internal, ?bool $wait, ?array $properties):void
    {
        try {
            $exchange = new Exchange($this->connection);
            $exchange($name, $type, $passive, $durable, $auto_delete, $internal, $wait, $properties);
        }catch (\Exception $exception){
            throw new RabbitMQException($exception->getMessage());
        }
    }

    public function publicMessage(string $queue, string $exchange,string  $routing_key, string  $message):void
    {
        try {
            $publisher = new Publisher($this->connection);
            $publisher($queue, $exchange, $routing_key, $message);
        }catch (\Exception $exception){
            throw new RabbitMQException($exception->getMessage());
        }
    }
}