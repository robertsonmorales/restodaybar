<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CategoryOfMenu;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";

    protected $fillable = [
        "category_menu_id", "img_src", "name", "price", "is_processed_by_cook", "status", "created_by", "updated_at"
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = ucfirst($value);
    }

    public function setIsProcessedByCookAttribute($value){
        $value = ($value == "on") ? 1 : 0;
        $this->attributes['is_processed_by_cook'] = $value;
    }

    public function setIsInventoriableAttribute($value){
        $value = ($value == "on") ? 1 : 0;
        $this->attributes['is_inventoriable'] = $value;
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function categoryMenu(){
        return $this->belongsTo(CategoryOfMenu::class, "category_menu_id", "id");
    }
}
