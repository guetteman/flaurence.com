<?php

namespace App\Domain\Graphs\Newsletter;

use App\Domain\LaraGraph\State;

class NewsletterState extends State
{
    /** @var array<string> */
    public array $urls = [];

    /** @var array<string> */
    public array $excludePaths = [];

    public string $topic = '';

    public string $description = '';

    /** @var array<array<string, string>> */
    public array $crawledPages = [];

    /** @var array<array<string, string>> */
    public array $summarizedPages = [];

    public string $output = '';

    /**
     * @param  array<string, mixed>  $input
     */
    public function __construct(string $graphId, array $input)
    {
        parent::__construct($graphId);
        $this->urls = data_get($input, 'urls', []);
        $this->topic = data_get($input, 'topic', '');
        $this->description = data_get($input, 'description', '');
        $this->excludePaths = data_get($input, 'exclude_paths', []);
    }
}
