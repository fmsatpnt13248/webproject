@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Orders</h2>

        <form method="GET" action="{{ route('orders.index') }}" class="flex items-center justify-between flex-wrap gap-4 mb-6">
            <select name="status" onchange="this.form.submit()" class="w-full md:w-1/3 p-3 border rounded shadow focus:outline-none focus:ring">
                <option value="">All Statuses</option>
                <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>

            <a href="{{ route('orders.create') }}">
                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    Create New Order
                </button>
            </a>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($orders as $order)
                <div class="border rounded-lg p-4 shadow hover:shadow-md transition">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold">Order #{{ $order->id }}</h3>
                        <span class="px-2 py-1 text-xs rounded font-medium {{
                        $order->status === 'draft' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'
                    }}">
                        {{ ucfirst($order->status) }}
                    </span>
                    </div>

                    <p class="text-sm text-gray-600">Placed by: {{ $order->user->name ?? 'N/A' }}</p>
                    <p class="mt-2 text-sm">Name: {{ $order->name }}</p>
                    <p class="text-sm">Customer: {{ $order->customer_name }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        @if ($order->status === 'pending')
                            <a href="{{ route('orders.view', $order) }}" class="text-blue-600 hover:underline">View</a>
                        @else
                            <a href="{{ route('orders.edit', $order) }}" class="text-blue-600 hover:underline">Edit</a>
                        @endif

                        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No orders found.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
