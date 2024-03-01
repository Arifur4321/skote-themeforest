<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Contract;  
use App\Models\VariableList; 
class ContractController extends Controller
{
    /**
     * Display a listing of the contracts.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Default to 10 items per page if not specified
        $contracts = Contract::paginate($perPage);
        $variables = VariableList::all();
        return view('ContractList', compact('contracts', 'variables'));
    }

 
    public function destroy($id)
    {
        $contract = Contract::find($id);
        
        if (!$contract) {
            return redirect()->back()->with('error', 'Contract not found.');
        }
        
        $contract->delete();
        
        return redirect()->back()->with('success', 'Contract deleted successfully.');
    }
 
    

    public function show()
    {
      
        $variables = VariableList::all();
        return view('ContractList', compact('variables'));
    }
    
    // public function savecontract(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'contract_name' => 'required|string',
            
    //         'editor_content' => 'required|string',
    //     ]);
    
    //     // Create a new Contract instance
    //     $contract = new Contract();
    //     $contract->contract_name = $request->input('contract_name');
  
    //     $contract->editor_content = $request->input('editor_content');
    //     $contract->logged_in_user_name = auth()->user()->name; // Assuming you have authentication
    //     //$contract->last_update_name = auth()->user()->name; // Assuming you have authentication
    //     $contract->save(); // Save the contract data
    
    //     // You can return a response to the client if needed
    //     return response()->json(['message' => 'Contract saved successfully']);
    // }
    

    public function savecontract(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'contract_name' => 'required|string',
            
            'editor_content' => 'required|string',
        ]);
    
        // Create a new Contract instance
        $contract = new Contract();
        $contract->contract_name = $request->input('contract_name');
  
        $contract->editor_content = $request->input('editor_content');
        $contract->logged_in_user_name = auth()->user()->name; // Assuming you have authentication
        //$contract->last_update_name = auth()->user()->name; // Assuming you have authentication
        $contract->save(); // Save the contract data
    
        // You can return a response to the client if needed
        return response()->json(['message' => 'Contract saved successfully']);

        
    }


    public function upload(Request $request)
    {
       if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }


    public function updatecontract(Request $request)
    {
        // Validation
        $request->validate([
            'id' => 'required|exists:contracts,id',
            'contract_name' => 'required|string',
            'editor_content' => 'required|string',
            // Add more validation rules as needed
        ]);
    
        // Find the contract by ID
        $contract = Contract::findOrFail($request->input('id'));
    
        // Update contract details
        $contract->update([
            'contract_name' => $request->input('contract_name'),
            'editor_content' => $request->input('editor_content'),
            // Include other fields if needed
        ]);
    
        // Return a JSON response indicating success
        return response()->json(['message' => 'Contract updated successfully'], 200);
    }
    


    public function edit($id)
    {
        $contract = Contract::findOrFail($id);

        return view('contracts.edit-modal', compact('contract'));
    }

 

}

