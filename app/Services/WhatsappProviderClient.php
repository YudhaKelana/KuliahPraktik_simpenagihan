<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappProviderClient
{
    private string $apiUrl;
    private string $apiToken;
    private string $provider;

    public function __construct()
    {
        $this->provider = config('samsat.wa.provider', 'fonnte');
        $this->apiUrl = config('samsat.wa.api_url', '');
        $this->apiToken = config('samsat.wa.api_token', '');
    }

    /**
     * Send a WhatsApp message.
     *
     * @return array ['message_id' => string|null, 'status' => string]
     * @throws \Exception
     */
    public function send(string $phone, string $message): array
    {
        if (empty($this->apiUrl) || empty($this->apiToken)) {
            // Simulate sending in dev mode
            Log::info("WA Simulated Send", ['phone' => $phone, 'message' => substr($message, 0, 100)]);
            return [
                'message_id' => 'sim_' . uniqid(),
                'status' => 'sent',
            ];
        }

        return match ($this->provider) {
            'fonnte' => $this->sendViaFonnte($phone, $message),
            default => $this->sendGeneric($phone, $message),
        };
    }

    private function sendViaFonnte(string $phone, string $message): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiToken,
        ])->post($this->apiUrl, [
            'target' => $phone,
            'message' => $message,
        ]);

        if (!$response->successful()) {
            throw new \Exception("Fonnte API Error: HTTP {$response->status()} - {$response->body()}");
        }

        $data = $response->json();
        if (isset($data['status']) && $data['status'] === false) {
            throw new \Exception("Fonnte Error: " . ($data['reason'] ?? 'Unknown'));
        }

        return [
            'message_id' => $data['id'] ?? null,
            'status' => 'sent',
        ];
    }

    private function sendGeneric(string $phone, string $message): array
    {
        $response = Http::withToken($this->apiToken)
            ->post($this->apiUrl, [
                'phone' => $phone,
                'message' => $message,
            ]);

        if (!$response->successful()) {
            throw new \Exception("WA API Error: HTTP {$response->status()}");
        }

        $data = $response->json();
        return [
            'message_id' => $data['message_id'] ?? $data['id'] ?? null,
            'status' => 'sent',
        ];
    }
}
