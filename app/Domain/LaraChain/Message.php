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

    /**
     * @param  array<string, mixed>  $inputs
     * @return array<string, string>
     */
    public function format(array $inputs): array
    {
        return [
            'role' => $this->role,
            'content' => str_replace(array_keys($inputs), array_values($inputs), $this->message),
        ];
    }
}
