<?php

namespace Khrokalo\SeoScanner;

use GuzzleHttp\Client;
use Khrokalo\SeoScanner\Result\SeoScannerResult;

class SeoScanner
{

    private static ?Client $client = null;

    public static function scan(string $url) : SeoScannerResult
    {
        $res = self::getClient()->request('GET', $url);
        $hasRobotsTxt = $res->getStatusCode() === 200;
        $content = $res->getBody()->getContents();
        $hasSitemap = $hasRobotsTxt && preg_match("!sitemap:(\s)?[^\s]+!i", $content);
        return new SeoScannerResult($hasRobotsTxt, $hasSitemap);
    }

    public static function getClient() : Client {
        if (self::$client === null) {
            self::$client = new Client();
        }
        return self::$client;
    }
}