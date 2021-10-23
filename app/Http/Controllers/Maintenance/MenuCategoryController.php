<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator, Arr, Auth;

use App\Models\MenuCategory;
use App\Models\User;

use App\Http\Controllers\UserAccountController as fromUser;

class MenuCategoryController extends Controller
{
    protected $category, $user;

    public function __construct(MenuCategory $category, User $user){
        $this->category = $category;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = ['Menu Categories'];
        $mode = [route('menu_categories.index')];
        
        $pagesize = [25, 50, 75, 100, 125];
        
        $rows = array();
        $rows = $this->category->latest()->get();
        $rows = $this->changeValue($rows);

        $columnDefs = array(            
            array('headerName'=>'NAME','field'=>'name', 'floatingFilter'=>false),
            array('headerName'=>'ICON','field'=>'icon', 'floatingFilter'=>false),
            array('headerName'=>'COLOR TAG','field'=>'color_tag', 'floatingFilter'=>false),
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

        return view('pages.menu_categories.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'data' => $data,
            'pagesize' => $pagesize,
            'create' => "menu_categories.create",
            'title' => 'Menu Categories'
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
        $name = ['Menu Categories', 'Create'];
        $mode = [route('menu_categories.index'), route('menu_categories.create')];

        $this->audit_trail_logs();

        return view('pages.menu_categories.form', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Menu Categories'
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

        $this->category->create($validated);

        $this->audit_trail_logs($request->all());

        return redirect()
            ->route('menu_categories.index')
            ->with('success', 'Menu Category Added Successfully!');
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
        $data = $this->category->findOrFail($id);

        $mode_action = 'update';
        $name = ['Menu Categories', 'Edit', $data->name];
        $mode = [route('menu_categories.index'), route('menu_categories.edit', $id), route('menu_categories.edit', $id)];

        $this->audit_trail_logs();

        return view('pages.menu_categories.form', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Menu Categories',
            'data' => $data
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

        $data = $this->category->find($id)->update($validated);

        $this->audit_trail_logs($request->all());

        return redirect()
            ->route('menu_categories.index')
            ->with('success', 'Menu Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->category->findOrFail($id)->delete();

        $this->audit_trail_logs();

        return redirect()->route('menu_categories.index')->with('success', 'Menu Category Deleted Successfully!');
    }

    public function validator(Request $request)
    {
        $input = [
            'name' => $this->safeInputs($request->input('name')),
            'icon' => $this->safeInputs($request->input('icon')),
            'color_tag' => $this->safeInputs($request->input('color_tag')),
            'status' => $this->safeInputs($request->input('status'))
        ];

        $rules = [
            'name' => 'required|string|unique:menu_categories,name,'.$this->safeInputs($request->input('id')),
            'icon' => 'required|string|unique:menu_categories,icon,'.$this->safeInputs($request->input('id')),
            'color_tag' => 'required|string',
            'status' => 'required|numeric'
        ];

        $messages = [];

        $customAttributes = [
            'name' => 'name',
            'icon' => 'icon',
            'color_tag' => 'color tag',
            'status' => 'status'
        ];

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    } 
}
