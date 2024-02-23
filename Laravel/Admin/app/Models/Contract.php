<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_name',
        'product_id',
        'editor_content',
        'logged_in_user_name',
    ];

    /**
     * Get the product associated with the contract.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
