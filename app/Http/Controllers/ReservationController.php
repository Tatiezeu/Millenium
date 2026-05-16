<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

/**
 * Controller to handle Restaurant Reservations.
 */
class ReservationController extends Controller
{
    /**
     * Store a new reservation.
     * Includes logic for recommending better tables based on guest count.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required',
            'guest_count' => 'required|integer|min:1',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
        ]);

        // Capture user info or guest info
        $userId = $request->user_id;
        $guestName = $request->guest_name;

        // If it's a guest from the dashboard and we want to keep their info
        // (Handled via user_id if they exist, or guest_name if new)

        // Safely convert string IDs to MongoDB ObjectIds
        $tableId = $request->table_id;
        if (is_string($tableId) && strlen($tableId) === 24 && ctype_xdigit($tableId)) {
            $tableId = new \MongoDB\BSON\ObjectId($tableId);
        }

        $userIdObjectId = $userId;
        if (is_string($userIdObjectId) && strlen($userIdObjectId) === 24 && ctype_xdigit($userIdObjectId)) {
            $userIdObjectId = new \MongoDB\BSON\ObjectId($userIdObjectId);
        }

        $reservation = Reservation::create([
            'table_id' => $tableId,
            'user_id' => $userIdObjectId,
            'guest_name' => $guestName,
            'guest_count' => $request->guest_count,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Note: We could mark the table as occupied here, but usually it's only 
        // occupied when they actually arrive. For now, we leave the table status.

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

    /**
     * Update reservation status (Confirm/Cancel).
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($request->has('status')) {
            $oldStatus = $reservation->status;
            $reservation->status = $request->status;
            $reservation->save();
            
            // Sync Table Status: If confirmed, mark table as occupied
            if ($reservation->status === 'confirmed' && $reservation->table) {
                $reservation->table->update(['status' => 'occupied']);
            } 
            // If it was confirmed but now cancelled, mark table as available
            elseif ($reservation->status === 'cancelled' && $oldStatus === 'confirmed' && $reservation->table) {
                $reservation->table->update(['status' => 'available']);
            }
        }

        return redirect()->back()->with('success', 'Reservation updated and table status synced!');
    }

    /**
     * Public reservation storage.
     * Checks if user is logged in, otherwise redirects to register.
     */
    public function publicStore(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('register')->with('info', 'Please register first to complete your reservation.');
        }

        // Logic similar to store, but automatically uses auth()->id()
        $request->validate([
            'table_id' => 'required',
            'guest_count' => 'required|integer|min:1',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
        ]);

        // Safely convert string IDs to MongoDB ObjectIds
        $tableId = $request->table_id;
        if (is_string($tableId) && strlen($tableId) === 24 && ctype_xdigit($tableId)) {
            $tableId = new \MongoDB\BSON\ObjectId($tableId);
        }

        $userIdObjectId = auth()->id();
        if (is_string($userIdObjectId) && strlen($userIdObjectId) === 24 && ctype_xdigit($userIdObjectId)) {
            $userIdObjectId = new \MongoDB\BSON\ObjectId($userIdObjectId);
        }

        $reservation = Reservation::create([
            'table_id' => $tableId,
            'user_id' => $userIdObjectId,
            'guest_count' => $request->guest_count,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Create notification for management
        \App\Models\Notification::create([
            'sender_id' => auth()->id(),
            'receiver_id' => 'restaurant manager', // Broadcast to all managers
            'message' => 'New reservation request from ' . auth()->user()->name . ' for table ' . ($reservation->table->title ?? 'N/A'),
            'type' => 'reservation',
            'is_read' => false,
        ]);

        return redirect('/')->with('success', 'Your reservation request has been sent! We will contact you soon.');
    }
}
