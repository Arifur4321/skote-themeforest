<?php



namespace App\Http\Controllers;

use App\Models\ArifurContract;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
 
class ArifurContractController extends Controller
{
    public function show()
    {
        // Return the arifurcontract.blade.php view
        return view('arifurcontract');
    }

 

    
public function save(Request $request)
{
    // Validate the request
    $request->validate([
        'title' => 'required|string',
        'content' => 'required|string',
    ]);

    // Create a new ArifurContract instance and save it to the database
    $contract = new ArifurContract();
    $contract->title = $request->title;
    $contract->content = $request->content;
    $contract->save();

    return response()->json(['success' => true]);
}
}