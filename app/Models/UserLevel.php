<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class UserLevel extends Model
{
    use HasFactory;

    protected $table = "user_levels";

    // scope here
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    // ends here

    // relationship here
    public function user(){
        return $this->belongsTo(User::class);
    }
    // ends here
}
