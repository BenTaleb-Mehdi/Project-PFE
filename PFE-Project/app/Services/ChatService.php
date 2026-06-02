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

        // Determine contact roles based on current user's role
        if ($user->hasRole('client')) {
            // Clients can only chat with Staff (Admins and Co-coaches)
            $contactQuery = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'co-coach']);
            });
        } else {
            // Staff can chat with all Clients and other Staff
            $contactQuery = User::where('id', '!=', $userId);
        }

        $contacts = $contactQuery->get();

        return $contacts->map(function ($contact) use ($userId) {
            // Get last message between current user and this contact
            $lastMessage = Message::where(function ($query) use ($userId, $contact) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $contact->id);
            })->orWhere(function ($query) use ($userId, $contact) {
                $query->where('sender_id', $contact->id)
                      ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->first();

            // Calculate unread count sent by this contact to the current user
            $unreadCount = Message::where('sender_id', $contact->id)
                                  ->where('receiver_id', $userId)
                                  ->where('is_read', false)
                                  ->count();

            // Find role
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
            // Sort by last message date, or id
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
