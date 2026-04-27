<?php

class SeoScanner
{
    /**
     * @return string[]
     */
    public static function scan(string $url) : array
    {
        return [
            'url' => $url,
        ];
    }
}