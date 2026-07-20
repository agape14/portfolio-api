<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public function notifyNewChatMessage(
        string $visitor_name,
        string $visitor_email,
        string $message
    ): bool {
        $bot_token = config('services.telegram.bot_token');
        $chat_id = config('services.telegram.chat_id');

        if (empty($bot_token) || empty($chat_id)) {
            Log::warning('Telegram credentials are not configured.');

            return false;
        }

        $text = $this->buildMessageText($visitor_name, $visitor_email, $message);

        try {
            $response = $this->sendMessage($bot_token, $chat_id, $text);

            if (! $response->successful()) {
                Log::error('Telegram API error.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            Log::info('Telegram notification sent.', [
                'chat_id' => $chat_id,
            ]);

            return true;
        } catch (\Throwable $exception) {
            Log::error('Failed to send Telegram notification.', [
                'message' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    private function buildMessageText(
        string $visitor_name,
        string $visitor_email,
        string $message
    ): string {
        return implode("\n", [
            '💬 Nuevo mensaje del chat',
            '',
            "👤 Nombre: {$visitor_name}",
            "📧 Correo: {$visitor_email}",
            '',
            '📝 Mensaje:',
            $message,
        ]);
    }

    private function sendMessage(string $bot_token, string $chat_id, string $text): Response
    {
        return Http::post(
            "https://api.telegram.org/bot{$bot_token}/sendMessage",
            [
                'chat_id' => $chat_id,
                'text' => $text,
            ]
        );
    }
}
