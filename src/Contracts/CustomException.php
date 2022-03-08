<?php

namespace MinamqpPhp\Contracts;

use Exception;

interface CustomException{
    public function message(): string;
    public function parentException(): ?Exception;
}