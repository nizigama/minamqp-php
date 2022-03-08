<?php

declare(strict_types=1);

namespace MinamqpPhp\Exceptions;

use MinamqpPhp\Contracts\CustomException;

class ConnectionFailed extends \Exception implements CustomException
{

    private string $customMessage;
    private \Exception $parentException;

    public function __construct(string $message, \Exception $parent)
    {
        parent::__construct($message, 1, $parent);
        $this->customMessage = $message;
        $this->parentException = $parent;
    }

    public function message(): string
    {
        return $this->customMessage;
    }

    public function __toString(): string
    {
        return $this->customMessage;
    }

    public function parentException(): ?\Exception
    {
        return $this->parentException;
    }
}
