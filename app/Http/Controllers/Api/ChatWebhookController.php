<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatWebhookController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegram_service
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'visitor_uuid' => 'required|string',
            'message' => 'required|string',
        ]);

        $conversation = ChatConversation::query()
            ->where('visitor_uuid', $validated['visitor_uuid'])
            ->firstOrFail();

        $chat_message = $conversation->messages()->create([
            'sender_type' => 'visitor',
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $this->telegram_service->notifyNewChatMessage(
            $conversation->visitor_name ?? 'Visitante',
            $conversation->visitor_email ?? 'sin-correo',
            $validated['message']
        );

        return response()->json([
            'success' => true,
            'message' => $chat_message,
        ]);
    }
}
