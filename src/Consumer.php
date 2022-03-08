<?php

declare(strict_types=1);

namespace MinamqpPhp;

use PhpAmqpLib\Message\AMQPMessage;

class Consumer{

    private static Connection $connection;

    public static function setConnection(Connection $connection)
    {
        self::$connection = $connection;
    }

    /** 
     * Accepts a callback, with a parameter of type string, that will read the content of the message,
     *  a bool to resend the message back to the server and a queueName in case you're not using the default queue.
     * This is a blocking function which means that it will never quit because it keeps waiting for an incoming message from the server, 
     * keep this in mind before calling it!
     */
    public static function read(callable $callback, bool $resendToQueue = false, string $queueName = ""){

        $usedQueueName = $queueName === "" ? self::$connection->defaultQueue : $queueName;

        $localCallback = function (AMQPMessage $message) use ($callback, $resendToQueue){
            $callback($message->getBody());
            $message->nack($resendToQueue);
        };

        self::$connection->channel->basic_consume($usedQueueName, '', false, false, false, false, $localCallback);

        while (self::$connection->channel->is_open()) {
            self::$connection->channel->wait();
        }
    }
}