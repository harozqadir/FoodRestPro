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
        'email',
        'password',
        'role',
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
    public function invoice_foods(){
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
        if($this->role== 1){
            return 'admin';
        }else if ($this->role == 2){
            return 'server';
        }else {
            return 'chife';
        }    }

        //permissions   

        public function isAdmin()
        {
            return $this->role == 1;
        }
        public function isServer()
        {
            return $this->role == 2;
        }

}
