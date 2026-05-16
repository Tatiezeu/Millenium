<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

/**
 * Controller to handle Menu Items (Services)
 * This controller facilitates CRUD operations for MongoDB documents.
 */
class ServiceController extends Controller
{
    /**
     * Store a newly created menu item in MongoDB.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation for the new menu item to ensure data integrity
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:meal,drink',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Create the service in the database using mass assignment
        Service::create([
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Menu item added successfully!');
    }

    /**
     * Update an existing menu item.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  The MongoDB _id of the item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Ensure inputs meet the requirements
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:meal,drink',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Retrieve the document from MongoDB
        $service = Service::findOrFail($id);
        
        // Mass-update the document with validated data
        $service->update($request->all());

        // Return to the previous page with a success toast notification
        return redirect()->back()->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item from the database.
     * 
     * @param  string  $id  The MongoDB _id of the item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Locate the service document or throw 404
        $service = Service::findOrFail($id);
        
        // Permanent deletion from the services collection
        $service->delete();

        // Notify user via flash message/toast
        return redirect()->back()->with('success', 'Menu item deleted successfully!');
    }
}
