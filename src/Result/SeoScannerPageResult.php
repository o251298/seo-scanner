<?php

namespace Khrokalo\SeoScanner\Result;

class SeoScannerPageResult
{
    public function __construct(
        private int   $httpStatus,
        private float $requestTimeMs,
        private bool  $hasTitle,
        private bool  $hasMetaDescription,
        private int   $h1Count,
        private int   $imgCount,
        private int   $imgWithoutAlt,
        private array $backlinksData,
    )
    {
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getRequestTimeMs(): float
    {
        return $this->requestTimeMs;
    }

    public function hasTitle(): bool
    {
        return $this->hasTitle;
    }

    public function hasMetaDescription(): bool
    {
        return $this->hasMetaDescription;
    }

    public function getH1Count(): int
    {
        return $this->h1Count;
    }

    public function getImgCount(): int
    {
        return $this->imgCount;
    }

    public function getImgWithoutAlt(): int
    {
        return $this->imgWithoutAlt;
    }

    public function getBacklinksData(): array
    {
        return $this->backlinksData;
    }
}