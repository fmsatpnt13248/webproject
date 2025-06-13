@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Edit Product</h2>

            <a href="{{ route('products.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                ← Back to Products
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border p-2 rounded">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label class="block font-medium">Price</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Category</label>
                <select name="category" class="w-full border p-2 rounded" required>
                    @foreach(['Food', 'Tools', 'Toys', 'Other'] as $cat)
                        <option value="{{ $cat }}" {{ $product->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Update Product
            </button>
        </form>
    </div>
@endsection
