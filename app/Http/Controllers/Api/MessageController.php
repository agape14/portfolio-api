<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegram_service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Message::query()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = Message::query()->create($validated);

        $this->telegram_service->notifyNewChatMessage(
            $validated['name'],
            $validated['email'],
            "Asunto: {$validated['subject']}\n\n{$validated['message']}"
        );

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 201);
    }

    public function show(int|string $id): JsonResponse
    {
        $message = Message::query()->findOrFail($id);

        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }

    public function destroy(int|string $id): Response
    {
        Message::query()->findOrFail($id)->delete();

        return response()->noContent();
    }

    public function unreadCount(): JsonResponse
    {
        $count = Message::query()->where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}
