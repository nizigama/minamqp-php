<?php

declare(strict_types=1);

namespace MinamqpPhp\Exceptions;

abstract class Failure extends \Exception
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
