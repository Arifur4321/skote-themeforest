<?php
 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableList extends Model
{
    use HasFactory;

    protected $primaryKey = 'VariableID'; // Specify the primary key

    protected $table = 'variable_lists';

    protected $fillable = [
        'VariableName',
        'VariableType',
        'Description',
    ];
}
