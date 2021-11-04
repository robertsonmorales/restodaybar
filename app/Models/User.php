<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Encryption\DecryptException;

use Crypt, Hash, Auth;

use App\Models\{UserLevel, UserBrowserSession};

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_level_id',
        'profile_image', 
        'profile_image_updated_at', 
        'profile_image_expiration_date', 
        'first_name', 
        'last_name', 
        'username', 
        'contact_number',
        'email', 
        'email_verified_at',
        'email_updated_at',
        'password',
        'password_updated_at',
        'password_expiration_date',
        'old_password',
        'address', 
        'status',
        'ip', 
        'access_level',
        'last_active_at',
        'remember_token',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'old_password',
        'temporary_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'profile_image_updated_at' => 'datetime',
        'profile_image_expiration_date' => 'datetime',
        'email_verified_at' => 'datetime',
        'email_updated_at' => 'datetime'
    ];

    // ACCESSORS
    public function getFirstNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // MUTATORS
    public function setFirstNameAttribute($value){
        $this->attributes['first_name'] = Crypt::encryptString(ucFirst($value));
    }

    // ACCESSORS
    public function getLastNameAttribute($value){
        return Crypt::decryptString($value);
    }

    // MUTATORS
    public function setLastNameAttribute($value){
        $this->attributes['last_name'] = Crypt::encryptString(ucFirst($value));
    }

    // ACCESSORS
    public function getContactNumberAttribute($value){
        return Crypt::decryptString($value);
    }

    // MUTATORS
    public function setContactNumberAttribute($value){
        $this->attributes['contact_number'] = Crypt::encryptString($value);
    }

    // MUTATORS
    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }
    
    // MUTATORS
    public function setOldPasswordAttribute($value){
        $this->attributes['old_password'] = Hash::make($value);
    }

    public function scopeHideAuthenticatedUser($query){
        return $query->where('id', '!=', Auth::id());
    }

    public function userLevel(){
        return $this->hasOne(UserLevel::class, 'user_level_id');
    }

    public function browserSessions(){
        return $this->hasMany(UserBrowserSession::class, 'user_id', 'id');
    }
}
