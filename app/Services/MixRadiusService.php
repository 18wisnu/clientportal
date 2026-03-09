<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MixRadiusService
{
    protected string $baseUrl;
    protected string $key;
    protected string $secret;

    public function __construct()
    {
        $this->baseUrl = config('services.mixradius.base_url') ?? '';
        $this->key = config('services.mixradius.key') ?? '';
        $this->secret = config('services.mixradius.secret') ?? '';

        if (empty($this->baseUrl)) {
            Log::error("MixRadius Configuration Error: MIX_RADIUS_BASE_URL is missing.");
        }
    }

    /**
     * Fetch customers from Mixradiusku API.
     * 
     * @return array
     */
    public function getCustomers(): array
    {
        try {
            // 1. Base URLs to test
            $host = parse_url($this->baseUrl, PHP_URL_HOST);
            $baseUrls = [
                $this->baseUrl, // Original (e.g., with :973)
                "https://{$host}", // Standard HTTPS
                "http://{$host}",  // Standard HTTP
            ];

            // 2. Authentication header variants
            $authVariants = [
                ['Key' => $this->key, 'Secret' => $this->secret],
                ['Authorization' => 'Bearer ' . $this->secret],
                ['Authorization' => 'Bearer ' . $this->key],
                ['Authorization' => 'Basic ' . base64_encode($this->key . ':' . $this->secret)],
                ['X-API-KEY' => $this->key, 'X-API-SECRET' => $this->secret],
            ];

            // 3. Common path patterns for MixRadius/ClientArea
            $paths = [
                "/api/client/v1/customer",
                "/api/client/v1/customers",
                "/api/v1/customers",
                "/api/v1/customer",
                "/clients/api/v1/customer",
                "/clientarea/api/v1/customer",
                "/rad-dashboard/api/v1/customer",
                "/api/public/v1/customer",
                "/api/customer",
            ];

            foreach (array_unique($baseUrls) as $baseUrl) {
                if (empty($baseUrl)) continue;

                foreach ($authVariants as $auth) {
                    $headers = array_merge($auth, [
                        'User-Agent' => 'MixRadius-Client/1.0',
                        'Accept' => 'application/json',
                    ]);

                    foreach ($paths as $path) {
                        $url = rtrim($baseUrl, '/') . $path;
                        try {
                            $response = Http::timeout(5)->withHeaders($headers)->withoutVerifying()->get($url);
                            $status = $response->status();
                            $body = $response->body();

                            // Skip if it's clearly an HTML page (MixRadius redirects to login if unauthorized or hitting web routes)
                            if ($status == 200 && (str_contains($body, '<html') || str_contains($body, '<script'))) {
                                continue;
                            }

                            if ($response->successful()) {
                                $data = $response->json();
                                if (!empty($data) && (isset($data['data']) || isset($data[0]) || isset($data['status']))) {
                                    Log::info("Success! Match found: {$url} with " . array_keys($auth)[0]);
                                    return $data['data'] ?? $data ?? [];
                                }
                            }
                        } catch (\Exception $e) {
                            // Silently continue for discovery, but log real connection issues if it's the configured URL
                            if ($baseUrl === $this->baseUrl) {
                                Log::debug("Failed attempt: {$url} - " . $e->getMessage());
                            }
                        }
                    }
                }
            }

            Log::error("MixRadius Sync: Broad discovery failed to find a valid JSON endpoint.");
            return [];
        } catch (\Exception $e) {
            Log::error("MixRadius Connection Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Sync customers to local database.
     * 
     * @return int Number of customers synced
     */
    public function syncCustomers(): int
    {
        Log::info("MixRadius Sync: Fetching customers from API...");
        $customersData = $this->getCustomers();
        
        if (empty($customersData)) {
            Log::warning("MixRadius Sync: No customer data received (empty list or API error).");
            return 0;
        }

        Log::info("MixRadius Sync: Found " . count($customersData) . " customers. Starting mapping...");
        $count = 0;

        foreach ($customersData as $data) {
            // Mapping logic based on expected API response
            // Adjust mappings as needed when API structure is confirmed
            \App\Models\Customer::updateOrCreate(
                ['username' => $data['username'] ?? $data['user']],
                [
                    'remote_id' => $data['id'] ?? null,
                    'name' => $data['name'] ?? ($data['username'] ?? $data['user']),
                    'package' => $data['package'] ?? $data['profile'] ?? null,
                    'status' => $data['status'] ?? 'active',
                    'expired_at' => isset($data['expiration']) ? \Illuminate\Support\Carbon::parse($data['expiration']) : null,
                ]
            );
            $count++;
        }

        return $count;
    }
}
