<?php

namespace App\Domain\LaraChain;

class PromptTemplate
{
    public function __construct(
        /** @var array<int, Message> */
        public array $messages,
    ) {}

    /**
     * @param  array<int, Message>  $messages
     */
    public static function fromMessages(array $messages): PromptTemplate
    {
        return new PromptTemplate($messages);
    }

    /**
     * @param  array<string, mixed>  $inputs
     * @return array<int, array<string, string>>
     */
    public function formatPrompt(array $inputs): array
    {
        $prompt = [];
        foreach ($this->messages as $message) {
            $prompt[] = $message->format($inputs);
        }

        return $prompt;
    }
}
