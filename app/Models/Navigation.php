<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $table = 'navigations';

    protected $fillable = ['nav_type', 'nav_name', 'nav_route', 'nav_controller', 'nav_icon', 'nav_order', 'nav_suborder', 'nav_childs_parent_id', 'status', 'created_by', 'updated_by'];

    public function scopeMainAndSingle($query){
        return $query->whereIn('nav_type', ['main', 'single']);
    }

    public function scopeActiveNav($query){
        return $query->where('status', 1);
    }

    public function scopeIsSingleOrMain($query){
        return $query->whereIn('nav_type', ['main', 'single']);
    }
}
