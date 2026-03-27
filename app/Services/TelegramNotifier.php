<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Throwable;

class TelegramNotifier
{
    public function isConfigured(): bool
    {
        return (string) config('services.telegram.bot_token') !== ''
            && (string) config('services.telegram.chat_id') !== '';
    }

    public function sendMessage(string $message): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        try {
            $response = $this->httpClient()
                ->asForm()
                ->timeout(10)
                ->post($this->endpoint('sendMessage'), [
                    'chat_id' => (string) config('services.telegram.chat_id'),
                    'text' => $message,
                ]);

            if (! $response->successful()) {
                Log::warning('Telegram API request was not successful.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            return $response->successful();
        } catch (Throwable $e) {
            Log::warning('Telegram notifier exception.', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function httpClient()
    {
        return app()->environment('local')
            ? Http::withoutVerifying()
            : Http::withOptions([]);
    }

    private function endpoint(string $method): string
    {
        return 'https://api.telegram.org/bot'.config('services.telegram.bot_token').'/'.$method;
    }
}
