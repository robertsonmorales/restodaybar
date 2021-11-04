<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth;
use Carbon\Carbon;

use App\Models\User;

class UserBrowserSession extends Model
{
    use HasFactory;

    protected $table = 'user_browser_sessions';

    protected $fillable = [
        'user_id',
        'device_family',
        'device_model',
        'plaform_family',
        'plaform_name',
        'browser',
        'ip_address',
        'mac_address'
    ];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function scopeMySessions($query){
        return $query->where('user_id', Auth::id());
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
