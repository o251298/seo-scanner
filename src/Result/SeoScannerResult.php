<?php

namespace Khrokalo\SeoScanner\Result;

class SeoScannerResult
{
    public function __construct(
        private bool $hasRobotsTxt,
        private bool $hasSitemap,
    )
    {
    }

    public function isHasSitemap(): bool
    {
        return $this->hasSitemap;
    }

    public function isHasRobotsTxt(): bool
    {
        return $this->hasRobotsTxt;
    }
}