<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * GET /api/notifications
     * Returns the latest 20 notifications for the authenticated user's role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['notifications' => [], 'unread_count' => 0]);
        }

        $role = $user->role ?? 'client'; // 'admin', 'co-coach', 'client'
        $targetRole = in_array($role, ['admin', 'co-coach']) ? 'admin' : 'client';

        $notifications = SystemNotification::forRole($targetRole)
            ->latest()
            ->take(20)
            ->get();

        $unreadCount = SystemNotification::forRole($targetRole)->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    /**
     * POST /api/notifications/{id}/read
     * Marks one notification as read.
     */
    public function markRead($id)
    {
        SystemNotification::where('id', $id)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    /**
     * POST /api/notifications/read-all
     * Marks all notifications as read for the current role.
     */
    public function markAllRead(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['success' => false]);

        $role = $user->role ?? 'client';
        $targetRole = in_array($role, ['admin', 'co-coach']) ? 'admin' : 'client';

        SystemNotification::forRole($targetRole)->unread()->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
