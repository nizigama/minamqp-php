<?php

declare(strict_types=1);

namespace MinamqpPhp;

use MinamqpPhp\Exceptions\PublishFailed;
use PhpAmqpLib\Message\AMQPMessage;

final class Producer
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /** 
     * Sends a message to the AMQP server,
     * returns true when the message is sent or throws an exception when it has failed
     *
     * @throws PublishFailed
     *
     */
    public function publish(string $message, string $exchange = "", string $queue = "", string $routingKey = ""): void
    {
        try {
            $msg = new AMQPMessage($message);

            $usedExchange = $exchange === "" ? $this->connection->defaultExchange : $exchange;
            
            $usedQueue = $queue === "" ? $this->connection->defaultQueue : $queue;

            $usedRoutingKey = $routingKey === "" ? $this->connection->defaultQueue : $routingKey;

            $this->connection->channel->queue_bind($usedQueue, $usedExchange, $usedRoutingKey);
            $this->connection->channel->basic_publish($msg, $usedExchange, $usedRoutingKey);
            return;
        } catch (\Exception $exception) {
            throw new PublishFailed("Failed to publish the message", $exception);
        }
    }
}
