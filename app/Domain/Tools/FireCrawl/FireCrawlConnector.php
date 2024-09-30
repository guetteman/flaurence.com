<?php

namespace App\Domain\Tools\FireCrawl;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class FireCrawlConnector extends Connector
{
    use AcceptsJson;

    public function __construct(
        public readonly string $baseUrl,
        public readonly string $token,
    ) {}

    /**
     * The Base URL of the API
     */
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
