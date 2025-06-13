@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-6">View Order: {{ $order->name }}</h2>

        <div class="mb-6">
            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
            <p><strong>Status:</strong>
                @if ($order->status === 'pending')
                    <span class="text-green-600 font-semibold">Pending</span>
                @else
                    <span class="text-gray-600">Draft</span>
                @endif
            </p>
        </div>

        <h3 class="text-xl font-semibold mb-2">Products in Order</h3>

        @if ($items->count())
            <table class="w-full border text-sm">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">Product</th>
                    <th class="p-2">Quantity</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr class="border-b">
                        <td class="p-2">{{ $item->product->name }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">{{ number_format($item->product->price, 2) }} USD</td>
                        <td class="p-2">{{ number_format($item->product->price * $item->quantity, 2) }} USD</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        @else
            <p class="text-gray-600 mt-4">No products added to this order.</p>
        @endif

        <div class="mt-6">
            <a href="{{ route('orders.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                ← Back to Orders
            </a>
        </div>
    </div>
@endsection
