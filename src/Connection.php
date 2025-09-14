<?php
declare(strict_types=1);
namespace GridCP\RabbitMQ_Client;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class Connection
{

    private ?string $host;
    private ?string $port;
    private ?string $username;
    private ?string $password;
    private ?string $vhost;
    private ?AMQPStreamConnection $connection;
    private ?AMQPChannel $channel = null;
    private ?string $queue;

    public function __construct(string $host, string $port, string $username, string $password, string $vhost)
    {

        $this->host= $host;
        $this->port= $port;
        $this->username= $username;
        $this->password= $password;
        $this->vhost = $vhost;

    }

    public function connect(string $queue): ?AMQPStreamConnection
    {
        $this->queue = $queue;
        try {
            $this->connection = new AMQPStreamConnection(
                $this->host,
                $this->port,
                $this->username,
                $this->password,
                $this->vhost
            );
            $this->channel = $this->connection->channel();
            $this->channel->queue_declare($this->queue, false, true, false, false);
            return $this->connection;
        }catch (\Exception $ex){
           throw new \Exception("Error ->".$ex->getMessage());
        }
    }

    public function getConnection(): AMQPStreamConnection{
        return $this->connection;
    }

    public function getChannel():?AMQPChannel
    {

        return ($this->channel)?$this->channel:null;
    }

    public function Queue():string
    {
        return $this->queue;
    }

    public function shutdown(){
        $this->channel->close();
        try {
            $this->connection->close();
        } catch (\Exception $e) {
            throw new \Exception("Error to close connection->". $e->getMessage());
        }
    }


}