<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class AuditTrailLogs extends Model
{
    use HasFactory;
    
    protected $table = 'audit_trail_logs';

    protected $fillable = [
        'route', 'module', 'method', 'user_id', 'remarks', 'ip', 'device'
    ];

    public function getUserIdAttribute($value){
        return User::find($value)->username;
    }
}