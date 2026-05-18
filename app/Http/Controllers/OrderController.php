<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;

/**
 * OrderController
 * Handles requests related to Order.
 */
class OrderController extends Controller
{
    /**
     * Store a new order from the public welcome page.
     */
    /**
     * Execute the store action.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'total_price' => 'required|numeric',
            'service_type' => 'required|in:served,delivered',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'table_id' => $request->table_id,
            'items' => $request->items,
            'total_price' => $request->total_price,
            'status' => 'pending',
            'notes' => $request->notes,
            'service_type' => $request->service_type,
            'location' => $request->location,
            'address' => $request->address,
        ]);

        session()->flash('success', 'Order placed successfully! Order #' . substr($order->id, -6));

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'order_id' => $order->id
        ]);
    }

    /**
     * Display the orders in the dashboard.
     */
    /**
     * Execute the index action.
     */
    public function index()
    {
        $orders = Order::with(['user', 'table'])->latest()->get();
        return view('dashboard.orders', compact('orders'));
    }

    /**
     * Update order status.
     */
    /**
     * Execute the updateStatus action.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;

        if ($request->has('preparation_time')) {
            $order->preparation_time = $request->preparation_time;
        }

        $order->save();

        return response()->json(['success' => true]);
    }

    /**
     * Print receipt for an order.
     */
    /**
     * Execute the printReceipt action.
     */
    public function printReceipt($id)
    {
        $order = Order::with(['user', 'table'])->findOrFail($id);
        return view('dashboard.print-receipt', compact('order'));
    }

    /**
     * Clear all orders in the database.
     */
    public function clearAll()
    {
        Order::query()->delete();
        return redirect()->back()->with('success', 'All orders cleared successfully!');
    }
}
