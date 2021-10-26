<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;

class ApiController extends Controller
{
    public function fetchCategories(){
        $data = $this->category->selectedFields()->active()->ascendingName()->get();

        $this->apiLog($data);

        $return = empty($data)
            ? array('message' => 'No records found')
            : $data;

        return response()->json($return);
    }

    public function fetchSubcategories(){
        $data = $this->subcategory->selectedFields()->active()->ascendingName()->get();
        $data = $this->changeValue($data);

        $this->apiLog($data);

        $return = empty($data)
            ? array('message' => 'No records found')
            : $data;

        return response()->json($return);
    }

    public function changeValue($rows){
        foreach ($rows as $key => $value) {
            if (Arr::exists($value, 'menu_category_id')) {
                $category = $this->subcategory->find($value['id'])->menuCategory->name;
                $value['menu_category_id'] = $category;
            }
        }

        return $rows;
    }
}
