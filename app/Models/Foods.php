<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
        use HasFactory;
        
//        protected $fillable = [
//     'name_en',
//     'name_ar',
//     'name_ckb',
//     'price',
//     'user_id',
//     'sub_category_id',
// ];

       protected $guarded = [];

     public function user()
       {       
           return $this->belongsTo(User::class, 'user_id');    
       }
       public function sub_category()
       {
       return $this->belongsTo(SubCategory::class,'sub_category_id');   

       }
       
    // Define a belongsTo relationship with Invoice
       public function invoice()
       {
           return $this->belongsTo(Invoice::class, 'invoice_id'); // Assuming 'invoice_id' exists in the 'foods' table
       }


protected $appends = ['created_at_readable','price_readable'];

    public function getCreatedAtReadableAttribute()
    {
        return $this->created_at?->diffForHumans();
    }

    public function getPriceReadableAttribute()
    {
        return number_format($this->price);
    }

    
  

}

