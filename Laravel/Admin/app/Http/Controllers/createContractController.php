<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\createcontract;
use App\Models\Product;
use App\Models\VariableList; 
use Illuminate\Http\RedirectResponse;

 

class createcontractController extends Controller
{

  

    public function productforcreatepage()
    {
        $products = Product::all(); // Retrieve all products from the database to pass to createcontract
        return view('createcontract', compact('products'));
    }
    
    public function show()
    {
      
        $variables = VariableList::all();
        $products = Product::all(); 
        return view('createcontract', compact('variables','products'));
    }

   
    public function store(Request $request)
    {
      

        return response()->json(['success' => true]);
    }
    


        
    public function save(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Create a new createcontract instance and save it to the database
        $contract = new createcontract();
        $contract->title = $request->title;
        $contract->content = $request->content;
        $contract->save();

        return response()->json(['success' => true]);
    }

    public function editmodal(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Create a new createcontract instance and save it to the database
        $contract = new createcontract();
        $contract->title = $request->title;
        $contract->content = $request->content;
        $contract->save();

        return response()->json(['success' => true]);
    }
}