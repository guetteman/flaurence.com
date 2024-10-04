<?php

namespace App\Domain\Graphs\Newsletter;

use App\Domain\LaraGraph\State;

class NewsletterState extends State
{
    public array $urls = [];

    public string $topic = '';

    public array $crawledPages = [];

    public array $summarizedPages = [];

    public string $output = '';

    public function __construct(array $input)
    {
        $this->urls = data_get($input, 'urls', []);
        $this->topic = data_get($input, 'topic', '');
    }
}
