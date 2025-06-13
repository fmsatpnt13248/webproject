@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Add New Product</h2>

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

        <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border p-2 rounded"></textarea>
            </div>

            <div>
                <label class="block font-medium">Price</label>
                <input type="number" name="price" step="0.01" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Category</label>
                <select name="category" class="w-full border p-2 rounded" required>
                    <option value="">-- Select Category --</option>
                    <option value="Food">Food</option>
                    <option value="Tools">Tools</option>
                    <option value="Toys">Toys</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
                Save Product
            </button>
        </form>
    </div>
@endsection
