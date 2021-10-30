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

    // scoping here
    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeAscendingName($query){
        return $query->orderBy('name', 'asc');
    }

    public function scopeSelectedFields($query){
        return $query->select('id', 'name', 'icon', 'color_tag');
    }
    // ends here

    // mutators here
    public function setNameAttribute($value){
        return $this->attributes['name'] = ucFirst($value);
    }
    // ends here

    // relationships here
    public function menuSubcategories(){
        return $this->hasMany(MenuSubcategory::class, 'menu_category_id', 'id');
    }
    // ends here
}
