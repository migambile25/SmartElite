<?php

namespace App\Services;

use CodeIgniter\Cache\CacheInterface;

class RateLimitService
{
    protected $cache;
    protected $config;

    public function __construct()
    {
        $this->cache = \Config\Services::cache();
        $this->config = config('RateLimit');
    }

    private function makeKey(string $ip, string $formSlug, string $suffix = ''): string
    {
        $raw = "rate_limit_{$ip}_{$formSlug}{$suffix}";
        return preg_replace('/[^A-Za-z0-9_]/', '_', $raw);
    }

    /**
     * Check if IP is rate limited for form submissions
     */
    public function isRateLimited(string $ip, string $formSlug = 'general'): bool
    {
        $key = $this->makeKey($ip, $formSlug);
        $attempts = $this->cache->get($key) ?: 0;
        
        return $attempts >= $this->config->maxAttempts;
    }

    /**
     * Record a submission attempt
     */
    public function recordAttempt(string $ip, string $formSlug = 'general'): void
    {
        $key = $this->makeKey($ip, $formSlug);
        $attempts = $this->cache->get($key) ?: 0;
        $attempts++;
        
        $this->cache->save($key, $attempts, $this->config->timeWindow);
    }

    /**
     * Get remaining attempts for IP
     */
    public function getRemainingAttempts(string $ip, string $formSlug = 'general'): int
    {
        $key = $this->makeKey($ip, $formSlug);
        $attempts = $this->cache->get($key) ?: 0;
        
        return max(0, $this->config->maxAttempts - $attempts);
    }

    /**
     * Get time until rate limit resets
     */
    public function getTimeUntilReset(string $ip, string $formSlug = 'general'): int
    {
        $key = $this->makeKey($ip, $formSlug);
        $ttl = $this->cache->getMetadata($key)['expire'] ?? 0;
        
        return max(0, $ttl - time());
    }

    /**
     * Check for suspicious patterns
     */
    public function isSuspiciousSubmission(array $submissionData, string $userAgent): bool
    {
        // Check for common bot patterns
        $suspiciousPatterns = [
            'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget', 'python', 'java'
        ];
        
        $userAgentLower = strtolower($userAgent);
        foreach ($suspiciousPatterns as $pattern) {
            if (strpos($userAgentLower, $pattern) !== false) {
                return true;
            }
        }

        // Check for suspiciously fast form completion (less than 2 seconds)
        // This would need to be implemented with session tracking
        
        // Check for common spam patterns in text fields
        $spamPatterns = [
            'viagra', 'casino', 'lottery', 'winner', 'congratulations',
            'click here', 'free money', 'make money', 'work from home'
        ];
        
        $flatValues = [];
        foreach ($submissionData as $value) {
            if (is_array($value)) {
                $flatValues[] = implode(' ', array_map('strval', $value));
            } elseif (is_scalar($value)) {
                $flatValues[] = (string) $value;
            }
        }
        $textContent = strtolower(implode(' ', $flatValues));
        foreach ($spamPatterns as $pattern) {
            if (strpos($textContent, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Log suspicious activity
     */
    public function logSuspiciousActivity(string $ip, string $reason, array $data = []): void
    {
        log_message('warning', "Suspicious activity detected from IP {$ip}: {$reason}", $data);
        
        // Could implement IP blocking here
        $this->recordAttempt($ip, 'suspicious');
    }
}
