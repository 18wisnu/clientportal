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
            // 1. Try different base URLs (with and without port)
            $baseUrls = [$this->baseUrl];
            if (str_contains($this->baseUrl, ':973')) {
                $baseUrls[] = str_replace(':973', '', $this->baseUrl);
            }

            // 2. Try different header combinations
            $headerSets = [
                ['Key' => $this->key, 'Secret' => $this->secret],
                ['X-API-KEY' => $this->key, 'X-API-SECRET' => $this->secret],
                ['Api-Key' => $this->key, 'Api-Secret' => $this->secret],
            ];

            // 3. Try different path patterns
            $paths = [
                "/api/client/v1/customer",
                "/api/client/v1/customers",
                "/api/public/v1/customer",
                "/api/public/v1/customers",
                "/api/v1/customer",
                "/rad-dashboard/api/v1/customer",
                "/api/public/customer",
            ];

            foreach ($baseUrls as $baseUrl) {
                foreach ($headerSets as $headers) {
                    $fullHeaders = array_merge($headers, [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'application/json',
                    ]);

                    foreach ($paths as $path) {
                        $url = rtrim($baseUrl, '/') . $path;
                        $response = Http::withHeaders($fullHeaders)->withoutVerifying()->get($url);
                        
                        $body = $response->body();
                        Log::debug("Testing MixRadius: {$url} | Headers: " . array_keys($headers)[0] . " | Status: " . $response->status());

                        if ($response->successful()) {
                            // Detect if it's a JS redirect or HTML login page
                            if (str_contains($body, '<script>') || str_contains($body, '<!DOCTYPE html>')) {
                                continue;
                            }

                            $data = $response->json();
                            if (!empty($data) && (isset($data['data']) || isset($data[0]) || isset($data['status']))) {
                                Log::info("Success! Found endpoint: {$url}");
                                return $data['data'] ?? $data ?? [];
                            }
                        }
                    }
                }
            }

            Log::error("MixRadius Sync: Exhausted all endpoint and header discovery variants without success.");
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
