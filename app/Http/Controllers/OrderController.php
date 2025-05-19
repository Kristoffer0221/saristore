<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()
            ->with(['user', 'items'])
            ->latest();

        // Payment method filter
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Search by order number or customer name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(5)->withQueryString();
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Order Placed,Order Confirmed,Order Packed,Shipped,In Transit,Out for Delivery,Delivered',
            'payment_status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string'
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'tracking_number' => $request->tracking_number,
            'courier_name' => $request->courier_name,
            'notes' => $request->notes
        ]);

        return back()->with('success', 'Order updated successfully');
    }
    
}