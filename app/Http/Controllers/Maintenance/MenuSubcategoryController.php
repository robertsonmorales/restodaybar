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
        $name = ['Menu Subcategories'];
        $mode = [route('menu_subcategories.index')];
        
        $pagesize = [25, 50, 75, 100, 125];
        
        $rows = array();
        $rows = $this->subcategory->latest()->get();
        $rows = $this->changeValue($rows);
        $rows = $this->changeValue2($rows);

        $columnDefs = array(
            array('headerName'=>'NAME','field'=>'name', 'floatingFilter'=>false),
            array('headerName'=>'CATEGORY','field'=>'menu_category_id', 'floatingFilter'=>false),
            array('headerName'=>'STATUS','field'=>'status', 'floatingFilter'=>false),
            array('headerName'=>'CREATED BY','field'=>'created_by', 'floatingFilter'=>false),
            array('headerName'=>'UPDATED BY','field'=>'updated_by', 'floatingFilter'=>false),
            array('headerName'=>'CREATED AT','field'=>'created_at', 'floatingFilter'=>false),
            array('headerName'=>'UPDATED AT','field'=>'updated_at', 'floatingFilter'=>false)
        );

        $data = json_encode(array(
            'rows' => $rows,
            'column' => $columnDefs
        ));

        $this->audit_trail_logs();

        return view('pages.menu_subcategories.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'data' => $data,
            'pagesize' => $pagesize,
            'create' => "menu_subcategories.create",
            'title' => 'Menu Subcategories'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mode_action = 'create';
        $name = ['Menu Subcategories', 'Create'];
        $mode = [route('menu_subcategories.index'), route('menu_subcategories.create')];

        $categories = $this->category->select('id', 'name', 'icon', 'color_tag', 'status')->active()->ascendingName()->get();

        $this->audit_trail_logs();

        return view('pages.menu_subcategories.form', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Menu Subcategories',
            'categories' => $categories
        ]);
    }

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
        $data = $this->subcategory->findOrFail($id);

        $mode_action = 'update';
        $name = ['Menu Subcategories', 'Edit', $data->name];
        $mode = [route('menu_subcategories.index'), route('menu_subcategories.edit', $id), route('menu_subcategories.edit', $id)];

        $categories = $this->category->select('id', 'name', 'icon', 'color_tag', 'status')->active()->ascendingName()->get();

        $this->audit_trail_logs();

        return view('pages.menu_subcategories.form', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Menu Subcategories',
            'data' => $data,
            'categories' => $categories
        ]);
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
