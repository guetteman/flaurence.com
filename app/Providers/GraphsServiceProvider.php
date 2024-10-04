<?php

namespace App\Providers;

use App\Domain\Graphs\Newsletter\NewsletterGraph;
use Illuminate\Support\ServiceProvider;

class GraphsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(NewsletterGraph::ID, fn () => new NewsletterGraph);
    }
}
