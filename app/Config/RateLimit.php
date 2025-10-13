<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class RateLimit extends BaseConfig
{
    /**
     * Maximum number of form submissions per time window
     */
    public int $maxAttempts = 5;

    /**
     * Time window in seconds (default: 1 hour)
     */
    public int $timeWindow = 3600;

    /**
     * Maximum submissions per day
     */
    public int $maxDailyAttempts = 20;

    /**
     * Time window for daily limit in seconds (24 hours)
     */
    public int $dailyTimeWindow = 86400;

    /**
     * Enable rate limiting
     */
    public bool $enabled = true;

    /**
     * Rate limit message
     */
    public string $rateLimitMessage = 'Too many submissions. Please try again later.';

    /**
     * Suspicious activity threshold
     */
    public int $suspiciousThreshold = 10;
}
