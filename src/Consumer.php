<?php

declare(strict_types=1);

namespace MinamqpPhp;

use PhpAmqpLib\Message\AMQPMessage;

final class Consumer{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /** 
     * Accepts a callback, with a parameter of type string, that will read the content of the message,
     *  a bool to resend the message back to the server and a queueName in case you're not using the default queue.
     * This is a blocking function which means that it will never quit because it keeps waiting for an incoming message from the server, 
     * keep this in mind before calling it!
     */
    public function read(callable $callback, bool $resendToQueue = false, string $queueName = ""): void{

        $usedQueueName = $queueName === "" ? $this->connection->defaultQueue : $queueName;

        $localCallback = function (AMQPMessage $message) use ($callback, $resendToQueue): void{
            $callback($message->getBody());
            $message->nack($resendToQueue);
        };

        $this->connection->channel->basic_consume($usedQueueName, '', false, false, false, false, $localCallback);

        while ($this->connection->channel->is_open()) {
            $this->connection->channel->wait();
        }
    }
}
