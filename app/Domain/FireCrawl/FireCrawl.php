<?php

namespace App\Domain\FireCrawl;

use App\Domain\FireCrawl\DataObjects\ScrapeResponseData;
use App\Domain\FireCrawl\Requests\ScrapeRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class FireCrawl
{
    public function __construct(
        protected FireCrawlConnector $connector,
    ) {}

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function scrape(string $url): ScrapeResponseData
    {
        return $this->connector
            ->send(new ScrapeRequest($url))
            ->dto();
    }
}
