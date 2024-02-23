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
    

    public function show()
    {
      
        $variables = VariableList::all();
        return view('ContractList', compact('variables'));
    }
    
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


  // public function create()
  //   {
  //       // Return the view for the contract creation form
  //       return view('contracts.create');
  //   }

  
  //   public function store(Request $request)
  //   {
  //       // Validate the request data
  //       $request->validate([
  //           'title' => 'required|string|max:255',
  //           'content' => 'required|string',
  //           // Add more validation rules as needed
  //       ]);

  //       // Create a new contract instance
  //       $contract = new Contract();
  //       $contract->title = $request->input('title');
  //       $contract->content = $request->input('content');
  //       // Add more fields as needed

  //       // Save the contract to the database
  //       $contract->save();

  //       // Redirect the user to a success page or do something else
  //       return redirect()->route('contracts.index')->with('success', 'Contract created successfully!');
  //   }

}

