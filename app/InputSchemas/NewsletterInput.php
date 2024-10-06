<?php

namespace App\InputSchemas;

class NewsletterInput
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function schema(): array
    {
        return [
            [
                'key' => 'topic',
                'label' => 'Topic',
                'type' => 'text_input',
                'input_type' => 'text',
                'placeholder' => 'Enter a topic',
                'description' => 'Enter a topic for the newsletter',
                'required' => true,
                'maxLength' => 255,
            ],
            [
                'key' => 'urls',
                'label' => 'URLs',
                'type' => 'array_input',
                'placeholder' => "https://url1.com\nhttps://url2.com\nhttps://url3.com",
                'required' => true,
                'minItems' => 1,
                'maxItems' => 5,
            ],
            [
                'key' => 'exclude_paths',
                'label' => 'Exclude Paths',
                'type' => 'array_input',
                'placeholder' => "/tags\n/archives\n/search",
                'required' => true,
                'minItems' => 1,
                'maxItems' => 10,
            ],
        ];
    }
}
