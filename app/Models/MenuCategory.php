<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MenuSubcategory;

class MenuCategory extends Model
{
    use HasFactory;

    protected $table = "menu_categories";

    protected $fillable = [
        "name", "icon", "color_tag", "status", "created_by", "updated_by"
    ];

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = ucFirst($value);
    }

    public function menuSubcategories(){
        return $this->hasMany(MenuSubcategory::class);
    }
}
