<?php

namespace App\Services;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ChatService
{
    /**
     * Get all chat contacts for a given user.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public function getContacts(int $userId)
    {
        $user = User::findOrFail($userId);

        if ($user->hasRole('client')) {
            $contactQuery = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'co-coach']);
            });
        } else {
            $contactQuery = User::where('id', '!=', $userId);
        }

        $contacts = $contactQuery->get();
        $contactIds = $contacts->pluck('id');

        $allUserMessages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest('created_at')
            ->get();

        $lastMessages = $allUserMessages->groupBy(function ($msg) use ($userId) {
            return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
        })->map->first();

        $unreadCounts = Message::where('receiver_id', $userId)
            ->whereIn('sender_id', $contactIds)
            ->where('is_read', false)
            ->groupBy('sender_id')
            ->selectRaw('sender_id, COUNT(*) as count')
            ->pluck('count', 'sender_id');

        return $contacts->map(function ($contact) use ($userId, $lastMessages, $unreadCounts) {
            $lastMessage = $lastMessages->get($contact->id);
            $unreadCount = $unreadCounts->get($contact->id, 0);
            $role = $contact->roles->first()?->name ?? 'user';

            return [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'role' => $role,
                'unread_count' => $unreadCount,
                'last_message' => $lastMessage ? [
                    'message' => $lastMessage->message,
                    'file_name' => $lastMessage->file_name,
                    'file_type' => $lastMessage->file_type,
                    'created_at' => $lastMessage->created_at->toIso8601String(),
                    'is_sender' => $lastMessage->sender_id === $userId,
                ] : null,
            ];
        })->sortByDesc(function ($contact) {
            return $contact['last_message']['created_at'] ?? '0';
        })->values();
    }

    /**
     * Get conversation between two users and mark incoming messages as read.
     *
     * @param int $userId
     * @param int $contactId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConversation(int $userId, int $contactId)
    {
        // Mark all unread messages from contact to current user as read
        Message::where('sender_id', $contactId)
               ->where('receiver_id', $userId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        // Retrieve messages
        return Message::where(function ($query) use ($userId, $contactId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $contactId);
        })->orWhere(function ($query) use ($userId, $contactId) {
            $query->where('sender_id', $contactId)
                  ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    }

    /**
     * Send a new message, handling optional image or file uploads.
     *
     * @param int $senderId
     * @param int $receiverId
     * @param string|null $messageText
     * @param UploadedFile|null $file
     * @return Message
     */
    public function sendMessage(int $senderId, int $receiverId, ?string $messageText, ?UploadedFile $file = null)
    {
        $filePath = null;
        $fileName = null;
        $fileType = null;

        if ($file) {
            $fileName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            
            // Categorize file type (image vs document/file)
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                $fileType = 'image';
            } else {
                $fileType = 'file';
            }

            // Secure storage directory under public/uploads/chats
            $destinationPath = public_path('uploads/chats');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $safeName = time() . '_' . uniqid() . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $filePath = '/uploads/chats/' . $safeName;
        }

        return Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $messageText,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'is_read' => false,
        ]);
    }
}
