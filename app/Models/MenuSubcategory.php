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
        "menu_category_id", "name", "icon", "status"
    ];

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = ucFirst($value);
    }

    public function menuCategory(){
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }
}
