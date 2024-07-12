<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
 
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
 
    protected $table = 'customers';
   
    // The primary key is already 'id' by default
    protected $primaryKey = 'id';
 
    protected $fillable = [
        'customer_number',
        'name',
        'email',
        'password',
        'location',
        'country_id',
        'mobile',
        'customer_account_id',
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
    ];
 
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
 
 