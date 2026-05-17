<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * EventController
 * Manages restaurant events, allowing administrators to schedule and display upcoming occasions.
 */
class EventController extends Controller
{
    /**
     * Store a newly created event.
     */
    /**
     * Execute the store action.
     */
    public function store(Request $request)
    {
        // Validate event data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        // Create the event record with default 'pending' status
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Event scheduled and is now pending confirmation!');
    }

    /**
     * Update the status of an event.
     */
    /**
     * Execute the updateStatus action.
     */
    public function updateStatus(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,upcoming,cancelled',
        ]);

        $event->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Event status updated to ' . $request->status);
    }

    /**
     * Remove an event from the system.
     */
    /**
     * Execute the destroy action.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Cleanup image from storage
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }
        
        $event->delete();

        return redirect()->back()->with('success', 'Event removed successfully!');
    }
}
