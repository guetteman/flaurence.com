<?php

namespace App\Domain\Graphs\Newsletter;

use App\Domain\LaraGraph\State;

class NewsletterState extends State
{
    /** @var array<string> */
    public array $urls = [];

    public string $topic = '';

    /** @var array<array<string, string>> */
    public array $crawledPages = [];

    /** @var array<array<string, string>> */
    public array $summarizedPages = [];

    public string $output = '';

    /**
     * @param  array<string, mixed>  $input
     */
    public function __construct(array $input)
    {
        $this->urls = data_get($input, 'urls', []);
        $this->topic = data_get($input, 'topic', '');
    }
}
