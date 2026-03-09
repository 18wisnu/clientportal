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
            $headers = [
                'Key' => $this->key,
                'Secret' => $this->secret,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
            ];

            $endpoints = [
                "/api/public/v1/customer",
                "/api/public/v1/customers",
                "/api/public/customer",
                "/api/clientarea/v1/customer",
                "/api/v1/customer",
            ];

            foreach ($endpoints as $endpoint) {
                $url = rtrim($this->baseUrl, '/') . $endpoint;
                $response = Http::withHeaders($headers)->withoutVerifying()->get($url);
                
                $body = $response->body();
                Log::debug("Testing MixRadius Endpoint: {$url} | Status: " . $response->status() . " | Body: " . substr($body, 0, 500));

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data)) {
                        Log::info("Success! Found endpoint: {$endpoint}");
                        return $data['data'] ?? $data ?? [];
                    }
                }
            }

            Log::error("MixRadius Sync: All tested endpoints failed or returned empty data.");
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
