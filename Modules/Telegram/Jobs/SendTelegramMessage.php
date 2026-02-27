<?php

namespace Modules\Telegram\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    protected string $chat_id;
    protected string $message;

    public function __construct(string $chat_id, string $message)
    {
        $this->chat_id = $chat_id;
        $this->message = $message;
    }

    public function handle(): void
    {
        $bot_token = config('telegram.bot_token');

        if (empty($bot_token) || empty($this->chat_id)) {
            return;
        }

        try {
            $response = Http::timeout(10)->post(
                "https://api.telegram.org/bot{$bot_token}/sendMessage",
                [
                    'chat_id' => $this->chat_id,
                    'text' => $this->message,
                    'parse_mode' => 'HTML',
                ]
            );

            if (!$response->ok()) {
                Log::warning('Telegram API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Telegram send error: ' . $e->getMessage());
        }
    }
}
