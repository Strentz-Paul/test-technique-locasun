<?php

namespace App\Helper\Api;

class ApiHelper
{
    public const ANNONCE_BASE_URL = "annonce";
    public const CONTENT_TYPE_FORMAT = "json";

    /**
     * @param string $baseUrl
     * @param string $identifier
     * @return string
     */
    public static function createUriFromResource(string $baseUrl, string $identifier): string
    {
        $baseUrl = rtrim($baseUrl, '/');
        $baseUrl = ltrim($baseUrl, '/');
        $baseUrl = "/$baseUrl/";
        return $baseUrl . ltrim($identifier, '/');
    }
}
