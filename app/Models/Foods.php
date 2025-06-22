<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');    
}
public function sub_category()
{
return $this->belongsTo(SubCategory::class,'sub_category_id');   

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

    public function orders()
{
    return $this->hasMany(Order::class, 'food_id');
}

}

