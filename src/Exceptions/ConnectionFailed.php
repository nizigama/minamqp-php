<?php

declare(strict_types=1);

namespace MinamqpPhp\Exceptions;

use MinamqpPhp\Contracts\Exception;
use Throwable;

class ConnectionFailed extends Exception {

    private string $message;
    private Exception $parentException;

    public function __construct(string $message, Exception $parent)
    {
        $this->message = $message;
        $this->parentException = $parent;
    }

    public function message(): string{
        return $this->message;
    }

    public function parentException(): ?Throwable{
        return $this->parentException;
    }
}