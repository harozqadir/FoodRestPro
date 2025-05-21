<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Table extends Model
{
   use HasFactory;
   protected $guarded = [];
   public Function user()
   {
      return $this->belongsTo(User::class,'user_id');
   }
   protected $appends = ['created_at_readable'];
   public function getCreatedAtReadableAttribute()
   {
      return $this->created_at?->diffForHumans();
   }
 
}
