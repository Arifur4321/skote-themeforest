<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\VariableList; 
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EditContractListController extends Controller
{

    public function showvariable()
    {
        $variables = VariableList::all();
        return view('Edit-ContractList', compact('variables'));
    }

     
    public function edit($id)
    {
       
        $contract = Contract::findOrFail($id);
        $variables = VariableList::all();
        $products = Product::all(); 
        return view('Edit-ContractList', compact('contract', 'variables', 'products'));
    }
    public function updateContract(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|exists:contracts,id',
            'contract_name' => 'required|string',
            'editor_content' => 'required|string',
            // Add validation rules for other fields if needed
        ]);
        
        // Find the contract by its ID
        $contract = Contract::findOrFail($request->id);
        
        // Update contract details
        $contract->contract_name = $request->contract_name;
        $contract->editor_content = $request->editor_content;
        // Update other fields as needed
        
        // Save the updated contract
        $contract->save();
        
        // Redirect back with a success message or return a response
        return response()->json(['message' => 'Contract updated successfully']);
    }
}
