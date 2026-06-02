<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->middleware('auth');
        $this->chatService = $chatService;
    }

    /**
     * Display the chat interface based on user role.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->hasRole('client')) {
            return view('client.chat.index');
        }

        return view('coach.chat.index');
    }

    /**
     * Get list of contacts for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContacts(Request $request)
    {
        $contacts = $this->chatService->getContacts(auth()->id());
        
        return response()->json([
            'success' => true,
            'contacts' => $contacts
        ]);
    }

    /**
     * Get all messages in a conversation.
     *
     * @param Request $request
     * @param int $contactId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages(Request $request, $contactId)
    {
        $messages = $this->chatService->getConversation(auth()->id(), (int) $contactId);
        
        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Send a message to a contact (supports file/image uploads).
     *
     * @param Request $request
     * @param int $contactId
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, $contactId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // Max 10MB file limit
        ]);

        if (!$request->filled('message') && !$request->hasFile('file')) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot send an empty message.'
            ], 422);
        }

        $message = $this->chatService->sendMessage(
            auth()->id(),
            (int) $contactId,
            $request->input('message'),
            $request->file('file')
        );

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
