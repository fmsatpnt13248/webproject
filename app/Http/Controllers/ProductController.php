<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ['Food', 'Tools', 'Toys', 'Other'];
        $selectedCategory = $request->query('category');

        $products = Product::when($selectedCategory, function ($query, $category) {
            return $query->where('category', $category);
        })->paginate(12);

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:Food,Tools,Toys,Other',
        ]);

        Product::create($request->only('name', 'description', 'price', 'category'));

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:Food,Tools,Toys,Other',
        ]);

        $product->update($request->only('name', 'description', 'price', 'category'));

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
