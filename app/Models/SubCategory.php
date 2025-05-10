<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
protected $guarded = [];

public function user()
{
    return $this->belongsTo(User::class, 'user_id');    
}
public function category()
{
return $this->belongsTo(Category::class);   

}
protected $appends = ['created_at_readable','full_path_image'];
    public function getCreatedAtReadableAttribute()
    {
        return $this->created_at?->diffForHumans();
    }

    public function getFullPathImageAttribute()
    {
        return env('APP_URL').'sub-categories-image/'.$this->image;
    }

}


