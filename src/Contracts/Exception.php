<?php

namespace MinamqpPhp\Contracts;

use Throwable;

interface Exception extends Throwable{

    public function message(): string;
    public function parentException(): ?Throwable;
}