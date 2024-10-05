<?php

use App\Domain\FireCrawl\DataObjects\GetCrawlStatusResponseData;
use App\Domain\FireCrawl\Enums\CrawlStatusEnum;
use App\Domain\FireCrawl\Requests\CrawlRequest;
use App\Domain\FireCrawl\Requests\GetCrawlStatusRequest;
use App\Domain\Tools\DocumentLoaders\FirecrawlLoader;
use Carbon\CarbonInterval;
use Illuminate\Support\Sleep;
use Saloon\Http\Faking\MockResponse;
use Saloon\Repositories\Body\JsonBodyRepository;

covers(FirecrawlLoader::class);

describe('FirecrawlLoader', function () {
    it('should load documents from a url', function () {
        Sleep::fake();

        $mockClient = Saloon::fake([
            MockResponse::make(
                body: [
                    'success' => true,
                    'id' => '1234567890',
                    'url' => 'https://test.test',
                ],
            ),
            MockResponse::make([
                'status' => CrawlStatusEnum::Scraping->value,
                'total' => 1,
                'completed' => 0,
                'creditsUsed' => 0,
                'expiresAt' => now()->addDay()->toIso8601String(),
                'next' => 'https://test.test',
                'data' => [],
            ]),
            MockResponse::make([
                'status' => CrawlStatusEnum::Completed->value,
                'total' => 1,
                'completed' => 1,
                'creditsUsed' => 1,
                'expiresAt' => now()->addDay()->toIso8601String(),
                'next' => null,
                'data' => [
                    [
                        'markdown' => '# Test',
                        'metadata' => [
                            'title' => 'Test',
                            'sourceURL' => 'https://test.test',
                            'statusCode' => 200,
                        ],
                    ],
                ],
            ]),
        ]);

        $loader = new FirecrawlLoader(
            url: 'https://test.test',
            apiKey: '1234567890',
        );

        $result = $loader->load();
        Sleep::assertSlept(fn (CarbonInterval $duration) => $duration->seconds === 3);
        $mockClient->assertSentCount(1, CrawlRequest::class);
        $mockClient->assertSentCount(2, GetCrawlStatusRequest::class);

        expect($result)->toBeInstanceOf(GetCrawlStatusResponseData::class);
    });

    it('should return null if the crawl job fails', function () {
        $mockClient = Saloon::fake([
            CrawlRequest::class => MockResponse::make(
                body: [
                    'success' => false,
                    'error' => 'Error',
                ],
            ),
        ]);

        $loader = new FirecrawlLoader(
            url: 'https://test.test',
            apiKey: '1234567890',
        );

        $result = $loader->load();
        $mockClient->assertSentCount(1, CrawlRequest::class);
        $mockClient->assertSentCount(0, GetCrawlStatusRequest::class);

        expect($result)->toBeNull();
    });

    it('should have a max limit of 3 documents per crawl by default', function () {
        Sleep::fake();
        $mockClient = Saloon::fake([
            MockResponse::make(
                body: [
                    'success' => true,
                    'id' => '1234567890',
                    'url' => 'https://test.test',
                ],
            ),
            MockResponse::make([
                'status' => CrawlStatusEnum::Completed->value,
                'total' => 1,
                'completed' => 1,
                'creditsUsed' => 1,
                'expiresAt' => now()->addDay()->toIso8601String(),
                'next' => null,
                'data' => [
                    [
                        'markdown' => '# Test',
                        'metadata' => [
                            'title' => 'Test',
                            'sourceURL' => 'https://test.test',
                            'statusCode' => 200,
                        ],
                    ],
                ],
            ]),
        ]);

        $loader = new FirecrawlLoader(
            url: 'https://test.test',
            apiKey: '1234567890',
        );

        $loader->load();

        $request = $mockClient->getRecordedResponses()[0]->getRequest();
        $reflectionClass = new ReflectionClass($request);
        $property = $reflectionClass->getProperty('body');
        /** @var JsonBodyRepository $body */
        $body = $property->getValue($request);

        expect($body->all()['limit'])->toBe(3);
    });
});
