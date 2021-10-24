<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Menu;

class CategoryOfMenu extends Model
{
    use HasFactory;

    protected $table = 'category_of_menus';

    protected $fillable = [
        "menu_category_id", "menu_subcategory_id", "created_by", "updated_by"
    ];

    public function menus(){
        return $this->hasOne(Menu::class);
    }
}
