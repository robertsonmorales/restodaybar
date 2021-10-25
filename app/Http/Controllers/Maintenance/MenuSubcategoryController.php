<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator, Arr, Auth;

class MenuSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->subcategory->latest()->get();
        $rows = $this->changeValue($rows);
        $rows = $this->changeValue2($rows);

        $columnDefs = array(
            array('headerName'=>'Name','field'=>'name'),
            array('headerName'=>'Category','field'=>'menu_category_id'),
            array('headerName'=>'Status','field'=>'status'),
            array('headerName'=>'Created By','field'=>'created_by'),
            array('headerName'=>'Created At','field'=>'created_at'),
            array('headerName'=>'Updated By','field'=>'updated_by'),
            array('headerName'=>'Updated At','field'=>'updated_at')
        );

        $data = json_encode(array(
            'rows' => $rows,
            'column' => $columnDefs
        ));

        $this->audit_trail_logs();
        
        // $view = target blade, $form = target form, $module = title of module, $data = datatable
        return $this->indexView($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // params here
        $categories = $this->category->select('id', 'name')->active()->ascendingName()->get();
        // ends here

        $this->audit_trail_logs();

        $params = [
            'mode' => 'create',
            'categories' => $categories
        ];

        return $this->formView($params);    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validator($request);
        $validated['created_by'] = Auth::id();

        $this->subcategory->create($validated);

        $this->audit_trail_logs($request->all());

        return redirect()
            ->route('menu_subcategories.index')
            ->with('success', 'Menu Subcategory Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // params here
        $data = $this->subcategory->findOrFail($id);
        $categories = $this->category->select('id', 'name')->active()->ascendingName()->get();
        // ends here

        $this->audit_trail_logs();

        $params = [
            'mode' => 'update',
            'data' => $data,
            'categories' => $categories
        ];

        return $this->formView($params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validator($request);
        $validated['updated_by'] = Auth::id();

        $data = $this->subcategory->find($id)->update($validated);

        $this->audit_trail_logs($request->all());

        return redirect()
            ->route('menu_subcategories.index')
            ->with('success', 'Menu Subcategory Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->subcategory->findOrFail($id)
            ->delete();

        $this->audit_trail_logs();

        return redirect()
            ->route('menu_subcategories.index')
            ->with('success', 'Menu Subcategory Deleted Successfully!');
    }

    public function validator(Request $request)
    {
        $input = [
            'menu_category_id' => $this->safeInputs($request->input('menu_category')),
            'name' => $this->safeInputs($request->input('name')),
            'status' => $this->safeInputs($request->input('status'))
        ];

        $rules = [
            'menu_category_id' => 'required|numeric',
            'name' => 'required|string|unique:menu_subcategories,name,'.$this->safeInputs($request->input('id')),
            'status' => 'required|numeric'
        ];

        $messages = [];

        $customAttributes = [
            'menu_category_id' => 'menu category',
            'name' => 'name',
            'status' => 'status'
        ];

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    }

    public function changeValue2($rows){
        foreach ($rows as $key => $value) {
            if(Arr::exists($value, 'menu_category_id')){
                $value['menu_category_id'] = $this->category->find($value['menu_category_id'])->name;
            }
        }

        return $rows;
    }
}
