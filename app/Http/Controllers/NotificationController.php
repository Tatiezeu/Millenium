<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * NotificationController
 * Manages user notifications, allowing sending and receiving messages between users.
 */
class NotificationController extends Controller
{
    /**
     * Store a newly created notification (message).
     * Now supports sending to specific roles or all staff accounts.
     */
    /**
     * Execute the store action.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'receiver_id' => 'required|string',
            'message' => 'required|string|max:1000',
            'parent_id' => 'nullable|string',
        ]);

        $receiverId = $request->receiver_id;
        $message = $request->message;
        $senderId = Auth::id();

        // Handle multiple attachments (up to 3)
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach (array_slice($request->file('attachments'), 0, 3) as $file) {
                $path = $file->store('notifications/attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize()
                ];
            }
        }

        // Check if receiver_id is a role or "all_staff"
        $roles = ['waiter', 'client', 'cook', 'manager', 'restaurant manager'];
        
        if (in_array($receiverId, $roles) || $receiverId === 'all_staff') {
            $query = User::query();
            
            if ($receiverId === 'all_staff') {
                $query->whereIn('role', ['waiter', 'cook', 'manager', 'restaurant manager']);
            } else {
                $query->where('role', $receiverId);
            }

            $users = $query->get();

            foreach ($users as $user) {
                Notification::create([
                    'sender_id' => $senderId,
                    'receiver_id' => $user->id,
                    'message' => $message,
                    'type' => 'message',
                    'is_read' => false,
                    'attachments' => $attachments,
                ]);
            }

            return redirect()->back()->with('success', 'Notifications sent to ' . str_replace('_', ' ', $receiverId) . ' successfully!');
        }

        // Fallback to single user if not a role
        Notification::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'type' => 'message',
            'is_read' => false,
            'attachments' => $attachments,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Notification sent successfully!');
    }

    /**
     * Mark a notification as read.
     */
    /**
     * Execute the markAsRead action.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('receiver_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
