<?php

namespace App\Domain\FireCrawl;

use App\Domain\FireCrawl\DataObjects\CrawlOptionsData;
use App\Domain\FireCrawl\Requests\CrawlRequest;
use App\Domain\FireCrawl\Requests\GetCrawlStatusRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;

class FireCrawlConnector extends Connector
{
    use AcceptsJson;

    public function __construct(
        public readonly string $baseUrl,
        public readonly string $token,
    ) {}

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function crawl(string $url, ?CrawlOptionsData $options = null): Response
    {
        return $this->send(new CrawlRequest($url, $options));
    }

    public function getCrawlStatus(string $crawlJobId): Response
    {
        return $this->send(new GetCrawlStatusRequest($crawlJobId));
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
