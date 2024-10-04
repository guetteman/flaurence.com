<?php

namespace App\InputSchemas;

class NewsletterInput
{
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
                'required' => true,
                'minItems' => 1,
                'maxItems' => 5,
            ],
        ];
    }
}
