<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Table extends Model
{
   use HasFactory;
   protected $guarded = [];
       protected $fillable = ['status', 'table_number', 'user_id'];

   public Function user()
   {
      return $this->belongsTo(User::class,'user_id');
   }

   public Function reservations()
   {
      return $this->hasMany(Reservation::class,'table_id');
   }

   public function invoices()
{
    return $this->hasMany(Invoice::class, 'table_id');
}

public function invoice()
       {
        //return $this->hasOne(Invoice::class, 'table_id')->where('status', 0);
    return $this->hasOne(\App\Models\Invoice::class)->where('status', 1)->latestOfMany();
  
      }

        

   protected $appends = ['created_at_readable'];
   public function getCreatedAtReadableAttribute()
   {
      return $this->created_at?->diffForHumans();
   }

   // One table has one open (unpaid) invoice
     
    /* ───── Scopes ───── */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
