<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $query = Product::query();

        // Check if the sort field is valid (name or price) and the sort order is valid (asc or desc).
        $validSortFields = ['name', 'price'];
        $validSortOrders = ['asc', 'desc'];

        if (in_array($sortField, $validSortFields) && in_array($sortOrder, $validSortOrders)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            // Default sorting if invalid parameters are provided.
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        return response()->json(['data' => $products]);
    }
    // Filter products based on a keyword.
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        // Perform the product search based on the keyword.
        $products = Product::where('name', 'like', "%$keyword%")
                            ->orWhere('description', 'like', "%$keyword%")
                            ->get();

        return response()->json(['data' => $products]);
    }
    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = Product::create($request->all());
        return response()->json(['data' => $product], 201);
    }

    // Display the specified resource.
    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['data' => $product]);
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => 'nullable',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product->update($request->all());
        return response()->json(['data' => $product]);
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
