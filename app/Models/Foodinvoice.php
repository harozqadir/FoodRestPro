<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foodinvoice extends Model
{
    use HasFactory;
     
   protected $fillable = [
     'invoice_id',
       'food_id',
       'quantity',
       'price',
        'user_id',
   ];

    protected $guqarded = [];
  // app/Models/InvoiceFood.php
protected $table = 'foodinvoices'; // <- use your actual table name


  // Define the relationship with Food
      public function food()
      {
          return $this->belongsTo(Foods::class, 'food_id');
      }

  // Define the relationship with Invoice
              public function invoice()
              {
                  return $this->belongsTo(Invoice::class, 'invoice_id');
              }
  // Define the relationship with User
              public function user()
                {        
                  return $this->belongsTo(User::class);
              }



}

