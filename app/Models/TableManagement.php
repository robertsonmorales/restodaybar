<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableManagement extends Model
{
    use HasFactory;

    protected $table = 'table_management';

    protected $fillable = [
        'name', 'no_seats', 'status', 'created_by', 'updated_by'
    ];

    public function scopeActive($query){
        return $query->where('status', 1);
    }
}
