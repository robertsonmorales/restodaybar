<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MenuCategory;

class MenuSubcategory extends Model
{
    use HasFactory;
    
    protected $table = "menu_subcategories";

    protected $fillable = [
        "menu_category_id", "name", "status", "created_by", "updated_by"
    ];

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = ucFirst($value);
    }

    public function scopeAscendingName($query){
        return $query->orderBy('name', 'asc');
    }
    
    public function menuCategory(){
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }
}
