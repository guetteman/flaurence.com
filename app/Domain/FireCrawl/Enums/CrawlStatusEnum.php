<?php

namespace App\Domain\FireCrawl\Enums;

enum CrawlStatusEnum: string
{
    case Scraping = 'scraping';
    case Completed = 'completed';
    case Failed = 'failed';
}
