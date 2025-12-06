<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Visitor: Start or Resume Conversation
    public function start(Request $request)
    {
        $request->validate([
            'visitor_uuid' => 'required|string',
            'visitor_name' => 'nullable|string',
            'visitor_email' => 'nullable|email',
            'visitor_phone' => 'nullable|string',
        ]);

        $conversation = ChatConversation::firstOrCreate(
            ['visitor_uuid' => $request->visitor_uuid],
            [
                'visitor_name' => $request->visitor_name,
                'visitor_email' => $request->visitor_email,
                'visitor_phone' => $request->visitor_phone,
                'status' => 'active'
            ]
        );

        // Update info if provided and was null or changed
        if ($request->visitor_name) $conversation->visitor_name = $request->visitor_name;
        if ($request->visitor_email) $conversation->visitor_email = $request->visitor_email;
        if ($request->visitor_phone) $conversation->visitor_phone = $request->visitor_phone;
        $conversation->save();

        // Notify Admin if it's a new conversation (no messages yet)
        if ($conversation->messages()->count() == 0) {
            try {
                // Replace with actual admin email or env variable
                Mail::raw("Nueva conversación de chat iniciada por: {$conversation->visitor_name} ({$conversation->visitor_email})", function ($message) {
                    $message->to(env('MAIL_FROM_ADDRESS', 'admin@example.com'))
                            ->subject('Nueva Conversación de Chat');
                });
            } catch (\Throwable $e) {
                Log::error('Error sending chat notification email: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'conversation' => $conversation
        ]);
    }

    // Visitor: Send Message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'visitor_uuid' => 'required|string',
            'message' => 'required|string',
        ]);

        $conversation = ChatConversation::where('visitor_uuid', $request->visitor_uuid)->firstOrFail();

        $message = $conversation->messages()->create([
            'sender_type' => 'visitor',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    // Visitor: Get Messages
    public function getMessages(Request $request)
    {
        $request->validate([
            'visitor_uuid' => 'required|string',
        ]);

        $conversation = ChatConversation::where('visitor_uuid', $request->visitor_uuid)->first();

        if (!$conversation) {
            return response()->json(['success' => true, 'messages' => []]);
        }

        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'conversation_status' => $conversation->status
        ]);
    }

    // Admin: List Conversations
    public function adminIndex()
    {
        $conversations = ChatConversation::with('messages')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($conv) {
                $conv->unread_count = $conv->messages()->where('sender_type', 'visitor')->where('is_read', false)->count();
                $conv->last_message = $conv->messages()->latest()->first();
                return $conv;
            });

        return response()->json([
            'success' => true,
            'conversations' => $conversations
        ]);
    }

    // Admin: Get Conversation Details
    public function adminShow($id)
    {
        $conversation = ChatConversation::with(['messages' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->findOrFail($id);

        // Mark messages as read
        $conversation->messages()->where('sender_type', 'visitor')->where('is_read', false)->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation
        ]);
    }

    // Admin: Reply
    public function adminReply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $conversation = ChatConversation::findOrFail($id);

        if ($conversation->status === 'closed') {
            return response()->json([
                'success' => false,
                'message' => 'La conversación está cerrada y no se pueden enviar más mensajes.'
            ], 403);
        }

        $message = $conversation->messages()->create([
            'sender_type' => 'admin',
            'message' => $request->message,
            'is_read' => true, 
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
    // Admin: Close Conversation
    public function adminClose($id)
    {
        $conversation = ChatConversation::findOrFail($id);
        $conversation->status = 'closed';
        $conversation->save();

        return response()->json([
            'success' => true,
            'message' => 'Conversación cerrada exitosamente'
        ]);
    }
}
