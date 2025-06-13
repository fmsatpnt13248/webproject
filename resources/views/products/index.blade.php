@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Product Catalog</h2>

        <form method="GET" action="{{ route('products.index') }}" class="flex items-center justify-between flex-wrap gap-4 mb-6">
            <select name="category" onchange="this.form.submit()" class="w-full md:w-1/3 p-3 border rounded shadow focus:outline-none focus:ring">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $selectedCategory === $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>

            <a href="{{ route('products.create') }}">
                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                    Add New Product
                </button>
            </a>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <div class="border rounded-lg p-4 shadow hover:shadow-md transition">
                    <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $product->category }}</p>
                    <p class="mt-2">{{ $product->description }}</p>
                    <p class="mt-1 font-bold text-green-700">{{ number_format($product->price, 2) }} USD</p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>

                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
