<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VariableList;
use App\Models\contractvariablecheckbox; 

class VariableListController extends Controller
{
    //to check how many time variable is checked

    public function countVariableIDs(Request $request)
    {
        // Get the VariableID from the request
        $variableID = $request->input('VariableID');

        // Count the total number of occurrences of the VariableID in the table
        $count = ContractVariableCheckbox::where('VariableID', $variableID)->count();

        // Count the number of different ContractIDs related to the VariableID in the table
        $countContract = ContractVariableCheckbox::where('VariableID', $variableID)
                                                ->distinct('ContractID')
                                                ->count('ContractID');

        // Return both counts as JSON response
        return response()->json([
            'count' => $count,
            'countContract' => $countContract
        ]);
    }

    // public function countVariableIDs(Request $request)
    // {
    //     // Get the VariableID from the request
    //     $variableID = $request->input('VariableID');

    //     // Count the number of occurrences of the VariableID in the table
    //     $count = ContractVariableCheckbox::where('VariableID', $variableID)->count();

    //     // Return the count as JSON response
    //     return response()->json(['count' => $count]);
    // }

    //to view all page
    public function index()
    {
        $variables = VariableList::all();
        return view('variablelist', compact('variables'));
        //return view('ProductList', compact('products'));
        //return view('variable-list.index', compact('variables'));
    }
    
    public function deleteContract($id)
    {
        $variable = VariableList::findOrFail($id); // Find the variable by ID
        $variable->delete(); // Delete the variable
        return redirect()->back()->with('success', 'Variable deleted successfully'); // Redirect back with success message
    }

    public function destroy($id)
        {
            $variable = Variable::find($id);
            
            if (!$variable) {
                return redirect()->back()->with('error', 'Variable not found.');
            }
            
            $variable->delete();
            
            return redirect()->back()->with('success', 'Variable deleted successfully.');
        }
 
    
    public function updateVariable(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'VariableName' => 'required|string',
            'VariableType' => 'required|string',
            // Add validation for Description if necessary
        ]);
    
        // Find the variable by ID
        $variable = VariableList::findOrFail($id);
    
        // Update variable details
        $variable->VariableName = $request->input('VariableName');
        $variable->VariableType = $request->input('VariableType');
    
        // Check if Description field is provided
        if ($request->has('Description')) {
            $variable->Description = $request->input('Description');
        }
    
        // Save the updated variable
        $variable->save();
    
        // Return a response indicating success
        return response()->json(['success' => true, 'message' => 'Variable updated successfully']);
 
    }
    

    public function saveVariable(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'VariableName' => 'required',
            'description' => 'required',
            'variableType' => 'required',
        ]);
    
        // Create a new VariableList instance
        $variableList = new VariableList;
    
        $variableList->VariableName = $validatedData['VariableName']; // Corrected to match the model property
        $variableList->description = $validatedData['description'];
        $variableList->variableType = $validatedData['variableType']; // Corrected to match the model property
    
        // Save the data to the database
        $variableList->save();
    
        // Optionally, you can return a response or redirect to another page
        return response()->json(['message' => 'Data saved successfully']);
    }


    // to show data in variable button modal table
    
    public function fetchVariables()
    {
        $variables = VariableList::all();
        return response()->json($variables);
    }
        

}


