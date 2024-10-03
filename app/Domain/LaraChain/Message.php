<?php

namespace App\Domain\LaraChain;

class Message
{
    public function __construct(
        public string $role,
        public string $message,
    ) {}

    public static function make(string $role, string $message): Message
    {
        return new Message($role, $message);
    }

    public function format(array $inputs): string
    {
        return str_replace(array_keys($inputs), array_values($inputs), $this->message);
    }
}
