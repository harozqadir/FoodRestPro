<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    protected $guqarded = [];
    // Allow mass assignment for these fields
    protected $fillable = [
        'table_id',       // Add table_id here
        'total_price',    // Ensure total_price is also fillable
        'status',        // Add other fields as needed
    ];
// Define the relationship with InvoiceFood
public function invoice_food()
{
    return $this->hasMany(Foodinvoice::class, 'invoice_id');
}

    
public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
    public function orders()
    {
        return $this->hasMany(Foodinvoice::class, 'invoice_id');
    }


}

