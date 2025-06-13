@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-6">Edit Order: {{ $order->name }}</h2>

        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('orders.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                ← Back to Orders
            </a>

            @if ($order->status !== 'pending')
                <form action="{{ route('orders.seal', $order) }}" method="POST" onsubmit="return confirm('Seal this order? It cannot be edited afterwards.');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                        Seal Order
                    </button>
                </form>
            @endif
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('orders.addProduct', $order) }}" method="POST" class="mb-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Select Product</label>
                    <select name="product_id" class="w-full border p-2 rounded" required>
                        <option value="">-- Choose Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ number_format($product->price, 2) }} USD)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium">Quantity</label>
                    <input type="number" name="quantity" min="1" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Add Product
            </button>
        </form>

        <h3 class="text-xl font-semibold mb-2">Products in Order</h3>

        @if ($items->count())
            <table class="w-full border text-sm">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">Product</th>
                    <th class="p-2">Quantity</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Total</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr class="border-b">
                        <td class="p-2">{{ $item->product->name }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">{{ number_format($item->product->price, 2) }} USD</td>
                        <td class="p-2">{{ number_format($item->product->price * $item->quantity, 2) }} USD</td>
                        <td class="p-2 text-right">
                            <form action="{{ route('orders.removeProduct', [$order, $item]) }}" method="POST" onsubmit="return confirm('Remove this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        @else
            <p class="text-gray-600 mt-4">No products added to this order yet.</p>
        @endif
    </div>
@endsection
