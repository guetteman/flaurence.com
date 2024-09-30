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
}
