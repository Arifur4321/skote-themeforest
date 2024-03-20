<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\VariableList; 
use App\Models\Product;
use App\Models\HeaderAndFooter;
use App\Models\contractvariablecheckbox; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
 
class EditContractListController extends Controller
{

    
   // to insert contractvariablecheckbox when pop up variable is checked

       public function insertContractVariable(Request $request)
       {
           // Retrieve contract_id and variable_id from the request
           $contractId = $request->input('contract_id');
           $variableId = $request->input('variable_id');
   
           // Insert data into the contractvariablecheckbox table
           $contractVariable = new contractvariablecheckbox();
           $contractVariable->ContractID = $contractId; // Update to match the actual column name in the table
           $contractVariable->VariableID = $variableId; // Update to match the actual column name in the table
           $contractVariable->save();
   
           // You can return a response if needed
           return response()->json(['message' => 'Data inserted successfully']);
       }

       //delete the row from contractvariablecheckbox when unchecked
       public function deleteContractVariable(Request $request)
       {
           // Retrieve the ContractID and VariableID from the request
           $contractId = $request->input('contract_id');
           $variableId = $request->input('variable_id');
       
           // Check if the checkbox is unchecked
           if (!$request->has('checked') || $request->input('checked') !== 'true') {
               // Delete rows from the database table where ContractID and VariableID match
               ContractVariableCheckbox::where('ContractID', $contractId)
                   ->where('VariableID', $variableId)
                   ->delete();
       
               // Respond with a success message or any necessary data
               return response()->json(['message' => 'Contract variable deleted successfully']);
           }
       
           // Respond with a message indicating that the checkbox is checked
           return response()->json(['message' => 'Checkbox is checked, no action taken']);
       }
       
    //    public function deleteContractVariable(Request $request)
    //    {
    //        // Retrieve the ContractID and VariableID from the request
    //        $contractId = $request->input('ContractID');
    //        $variableId = $request->input('VariableID');
   
    //        // Delete rows from the database table where ContractID and VariableID match
    //        ContractVariableCheckbox::where('ContractID', $contractId)
    //            ->where('VariableID', $variableId)
    //            ->delete();
   
    //        // Respond with a success message or any necessary data
    //        return response()->json(['message' => 'Contract variable deleted successfully']);
    //    }

       // checked the variableID corresponding to contractID
       public function checkedVariable(Request $request)
        {
            $contractID = $request->input('contract_id');

            // Assuming ContractVariableCheckbox is the correct model for the contractvariablecheckbox table
            $variableIDs = ContractVariableCheckbox::where('ContractID', $contractID)->pluck('VariableID')->toArray();

            return response()->json($variableIDs);
        }

   // ----------------
 
    // testing method 
    public function showvariable()
    {  
        $loggedInUserName = auth::user()->name ;
        $headerEntries = HeaderAndFooter::where('type', 'Header')->pluck('name', 'id')->toArray();
        $footerEntries = HeaderAndFooter::where('type', 'Footer')->pluck('name', 'id')->toArray();
        $variables = VariableList::all();
        return view('Edit-ContractList', compact('variables','headerEntries', 'footerEntries', 'loggedInUserName'));
    }

     
    public function edit($id)
    {
       
        $contract = Contract::findOrFail($id);
        $variables = VariableList::all();
        $products = Product::all(); 
        $headerEntries = HeaderAndFooter::where('type', 'Header')->pluck('name', 'id')->toArray();
        $footerEntries = HeaderAndFooter::where('type', 'Footer')->pluck('name', 'id')->toArray();
        return view('Edit-ContractList', compact('contract', 'variables', 'products','headerEntries', 'footerEntries'));
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
