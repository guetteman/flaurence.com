<?php

namespace App\Domain\Tools\FireCrawl;

use App\Domain\Tools\FireCrawl\DataObjects\ExtractResponseData;
use App\Domain\Tools\FireCrawl\DataObjects\ScrapeResponseData;
use App\Domain\Tools\FireCrawl\Requests\ExtractRequest;
use App\Domain\Tools\FireCrawl\Requests\ScrapeRequest;
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

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function extract(string $url, string $prompt): ExtractResponseData
    {
        return $this->connector
            ->send(new ExtractRequest($url, $prompt))
            ->dto();
    }
}
