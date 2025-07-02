<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'role',
        'created_by',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
   
    //relations

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

 
    public function users(){
        return $this->hasMany(User::class,'user_id');
    }
    public function categories(){
        return $this->hasMany(Category::class,'user_id');
    }
    public function sub_categories (){
        return $this->hasMany(SubCategory::class,'user_id');
    }
    public function foods(){
        return $this->hasMany(Foods::class,'user_id');
    }
    public function tables(){
        return $this->hasMany(Table::class,'user_id');
    }
    public function reservations(){
        return $this->hasMany(Reservation::class,'user_id');
    }
    public function invoices(){
        return $this->hasMany(Invoice::class,'user_id');
    }
    public function invoice_food(){
        return $this->hasMany(Foodinvoice::class,'user_id');
    }

    
    
  //appends
  protected $appends = ['created_at_readable','role_readable'];
    public function getCreatedAtReadableAttribute()
    {
        return $this->created_at?->diffForHumans();
    }

    public function getRoleReadableAttribute()
{
    switch ($this->role) {
        case 1:
            return 'admin';
        case 2:
            return 'server';
        case 3:
            return 'chief';
        case 4:
            return 'casher';
        
    }
}

// Permissions
public function isAdmin()
{
    return $this->role == 1; // Compare to numeric value
}

public function isServer()
{
    return $this->role == 2; // Compare to numeric value
}

public function isChief()
{
    return $this->role == 3; // Compare to numeric value
}

public function isCasher()
{
    return $this->role == 4; // Compare to numeric value
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
