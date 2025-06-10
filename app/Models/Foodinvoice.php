<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foodinvoice extends Model
{
    protected $guqarded = [];
  // Allow mass assignment for these fields
  protected $fillable = [
    'invoice_id',    // Add invoice_id here
    'food_id',       // Add food_id here
    'quantity',      // Add quantity here
    'price',         // Add price here
    'table_id',       // Add table_id here
    'total_price',    // Ensure total_price is also fillable
    'user_id',        // Add other fields as needed
];
}
