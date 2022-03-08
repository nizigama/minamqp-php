<?php

declare(strict_types=1);

namespace MinamqpPhp;

use MinamqpPhp\Exceptions\PublishFailed;
use PhpAmqpLib\Message\AMQPMessage;

class Producer
{

    private static Connection $connection;

    public static function setConnection(Connection $connection)
    {
        self::$connection = $connection;
    }

    /** 
     * Sends a message to the AMQP server, 
     * returns true when the message is sent or throws an exception when it has failed
     * 
     * @throws PublishFailed
     * 
     */
    public static function publish(string $message, string $exchange = "", string $routingKey = ""): bool
    {
        try {
            $msg = new AMQPMessage($message);

            $usedExchange = $exchange === "" ? self::$connection->defaultExchange : $exchange;

            $usedRoutingKey = $routingKey === "" ? self::$connection->defaultQueue : $routingKey;

            self::$connection->channel->basic_publish($msg, $usedExchange, $usedRoutingKey);
            return true;
        } catch (\Exception $exception) {
            throw new PublishFailed("Failed to publish the message", $exception);
        }
    }
}
