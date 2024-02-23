<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
 
 

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('ProductList', compact('products'));
    }

    public function productforcreatepage()
    {
        $products = Product::all(); // Retrieve all products from the database to pass createcontract
        return view('createcontract', compact('products'));
    }

    public function saveProduct(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
        
            'productName' => 'required',
            'description' => 'required',
    
        
        ]);

    // Create a new product instance
    $product = new Product;
 
    $product->product_name = $validatedData['productName'];
    $product->description = $validatedData['description'];
   
 

    // Save the product to the database
    $product->save();

    // Optionally, you can return a response or redirect to another page
    return response()->json(['message' => 'Product saved successfully']);
    }

}



