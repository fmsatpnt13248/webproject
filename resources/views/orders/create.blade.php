@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Add New Order</h2>

            <a href="{{ route('orders.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                ← Back to Orders
            </a>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Order Name</label>
                <input type="text" name="name" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-medium">Customer Name</label>
                <input type="text" name="customer_name" required class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Create Order
            </button>
        </form>
    </div>
@endsection
