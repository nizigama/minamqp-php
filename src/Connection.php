<?php

declare(strict_types=1);

namespace MinamqpPhp;

use MinamqpPhp\Exceptions\ConnectionFailed;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class Connection{

    private string $host;
    private int $port;
    private string $user;
    private string $password;
    public string $defaultExchange;
    public string $defaultQueue;
    private string $vhost;
    public AMQPChannel $channel;

    public function __construct(string $host, int $port, string $user, string $password, string $exchange = "", string $queue = "", string $vhost = '/')
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->defaultExchange = $exchange;
        $this->defaultQueue = $queue;
        $this->vhost = $vhost;
    }

    /** 
     * Attempts to connect to the AMQP server
     * 
     * @throws ConnectionFailed
     */
    public function connect(): void
    {
        try {
            $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password, $this->vhost);
            $this->channel = $connection->channel();
        } catch (\Exception $ex) {
            throw new ConnectionFailed("Connection to AMQP server failed", $ex);
        }
    }
}
