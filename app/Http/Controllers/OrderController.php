<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::with('user')
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders', 'status'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
        ]);

        $order = Order::create([
            'name' => $request->name,
            'customer_name' => $request->customer_name,
            'status' => 'draft',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('orders.edit', $order->id)->with('success', 'Order created.');
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        $items = $order->items()->with('product')->paginate(5);

        return view('orders.edit', compact('order', 'products', 'items'));
    }

    public function addProduct(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Product added to order.');
    }

    public function removeProduct(Order $order, OrderItem $item)
    {
        if ($item->order_id !== $order->id) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Product removed.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    public function seal(Order $order)
    {
        if ($order->status === 'pending') {
            return back()->with('info', 'Order is already sealed.');
        }

        $order->update([
            'status' => 'pending',
        ]);

        return redirect()->route('orders.index')->with('success', 'Order is now pending.');
    }

    public function view(Order $order)
    {
        $items = $order->items()->with('product')->paginate(5);

        return view('orders.view', compact('order', 'items'));
    }
}
