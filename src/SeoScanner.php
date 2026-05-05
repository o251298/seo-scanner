<?php

namespace Khrokalo\SeoScanner;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Khrokalo\SeoScanner\Result\SeoScannerPageResult;
use Symfony\Component\DomCrawler\Crawler;

class SeoScanner
{

    /**
     * @var SeoScannerPageResult[]
     */
    private array $resultsCache = [];

    public function __construct(private ClientInterface $client)
    {
    }

    public function scanPage(string $url) : SeoScannerPageResult
    {
        assert(self::isValidUrl($url));
        if (array_key_exists($url, $this->resultsCache)) {
            return $this->resultsCache[$url];
        }
        $start = microtime(true);
        $response = $this->client->request('GET', $url);
        $timeMs = (microtime(true) - $start) * 1000;
        $statusCode = $response->getStatusCode();
        $contentHtml = $response->getBody()->getContents();
        $crawler = new Crawler($contentHtml);
        $hasTitle = $crawler->filter('head title')->count() !== 0;
        $hasMeta = false;
        if ($crawler->filter('meta[name="description"]')->count() !== 0) {
            $hasMeta = $crawler->filter('meta[name="description"]')->first()->attr('content') !== '';
        }
        $h1Count = $crawler->filter('body h1')->count();
        $imgCount = $crawler->filter('body img')->count();
        $imgWithoutAlt = $crawler->filter('img:not([alt]), img[alt=""]')->count();
        $result = new SeoScannerPageResult($statusCode, $timeMs, $hasTitle, $hasMeta, $h1Count, $imgCount, $imgWithoutAlt, []);
        $this->resultsCache[$url] = $result;
        return $result;
    }

    private function isValidUrl(string $url) : bool
    {
        return (bool) filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function createFromGuzzleClient() : self
    {
        return new self(new Client());
    }
}