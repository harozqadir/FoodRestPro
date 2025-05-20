<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
use HasFactory;
protected $guarded = [];
public function user()
{
    return $this->belongsTo(User::class, 'user_id');    
}

public function sub_categories()
{
    return $this->hasMany(SubCategory::class, 'category_id');
}

protected $appends = ['created_at_readable','full_path_image'];
    public function getCreatedAtReadableAttribute()
    {
        return $this->created_at?->diffForHumans();
    }

    public function getFullPathImageAttribute()
    {
        return env('APP_URL').'categories-image/'.$this->image;
    }
}