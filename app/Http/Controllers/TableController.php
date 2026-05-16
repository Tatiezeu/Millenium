<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;

/**
 * Controller to handle Restaurant Table management.
 */
class TableController extends Controller
{
    /**
     * Store a newly created table in MongoDB.
     */
    public function store(Request $request)
    {
        // ... (existing store logic) ...
        $request->validate([
            'title' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'category' => 'required|in:Standard,Medium,First Class',
            'price' => 'required|numeric|min:0',
            'area' => 'required|string',
        ]);

        Table::create([
            'title' => $request->title,
            'seats' => $request->seats,
            'category' => $request->category,
            'price' => $request->price,
            'area' => $request->area,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Table added successfully!');
    }

    /**
     * Update table status (Toggle between Available and Occupied).
     */
    public function toggleStatus($id)
    {
        $table = Table::findOrFail($id);
        $table->status = ($table->status === 'available') ? 'occupied' : 'available';
        $table->save();

        return redirect()->back()->with('success', 'Table status updated!');
    }

    /**
     * Remove a table from the database with safety checks.
     */
    public function destroy($id)
    {
        $table = Table::findOrFail($id);

        // Safety Check: Prevent deletion if reservations exist
        $reservationCount = Reservation::where('table_id', $id)->count();
        if ($reservationCount > 0) {
            return redirect()->back()->with('error', "Cannot delete this table because it has $reservationCount active reservation(s).");
        }

        $table->delete();
        return redirect()->back()->with('success', 'Table removed successfully!');
    }
}
