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
        'table_id',
        'created_by_server',
        'total_price',
        'status',           // << Add this line
        'paid_by',
        // other columns...
    ];
  // Optionally, add casting for data types
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    
    // Define a hasMany relationship with Foods (or another table storing food details)
   
    public function table()
{
    return $this->belongsTo(Table::class, 'table_id');}
     
public function casher()
{
    return $this->belongsTo(User::class, 'user_id');
}
// In the Invoice model (Invoice.php)
public function creator()
{
    return $this->belongsTo(User::class, 'created_by_server');
}
public function invoice_food()
{
    return $this->hasMany(Foodinvoice::class, 'invoice_id');
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // customer
}
public function paidBy()
{
    return $this->belongsTo(User::class, 'paid_by');
}
public function foodinvoices()
{
    return $this->hasMany(FoodInvoice::class);
}
public function server()
{
    return $this->belongsTo(User::class, 'created_by_server');
}
public function foodItems()
{
    return $this->hasMany(FoodInvoice::class);
}

}