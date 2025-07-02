<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{    
    // Example: 0 = open, 1 = ordered, 2 = paid, etc.

    const STATUS_OPEN = 0;
    const STATUS_ORDERED = 1;
    const STATUS_PAID = 2;

    use HasFactory;
    protected $guqarded = [];
    // Allow mass assignment for these fields
    protected $fillable = [
        'table_id',
        'created_by',      // Server who created the invoice
        'user_id',         // Casher who paid the invoice (or use 'paid_by' if that's your column)
        'invoice_number',
        'status',
        'total_price',
        // Add other columns as needed
    ];
// Define the relationship with InvoiceFood
public function invoice_food()
{
    return $this->hasMany(Foodinvoice::class, 'invoice_id');
}

    
    // Define a hasMany relationship with Foods (or another table storing food details)
   
    public function table()
{
    return $this->belongsTo(Table::class);
}
     
public function casher()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
}