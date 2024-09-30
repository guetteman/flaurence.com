<?php

namespace App\Domain\Tools\FireCrawl;

enum CrawlStatusEnum: string
{
    case Scraping = 'scraping';
    case Completed = 'completed';
    case Failed = 'failed';
}
