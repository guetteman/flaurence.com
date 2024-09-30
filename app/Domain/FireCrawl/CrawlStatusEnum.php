<?php

namespace App\Domain\FireCrawl;

enum CrawlStatusEnum: string
{
    case Scraping = 'scraping';
    case Completed = 'completed';
    case Failed = 'failed';
}
