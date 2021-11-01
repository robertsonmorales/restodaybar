<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, Validator, Str;

class UserLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->userLevel->latest()->get();

        $columnDefs = array(
            array('headerName' => 'NAME', 'field' => 'name'),
            array('headerName' => 'DESCRIPTION', 'field' => 'description'),
            array('headerName' => 'CREATED BY', 'field' => 'created_by'),
            array('headerName' => 'UPDATED BY', 'field' => 'updated_by'),
            array('headerName' => 'CREATED AT', 'field' => 'created_at'),
            array('headerName' => 'UPDATED AT', 'field' => 'updated_at')
        );

        $data = json_encode(array(
            'column' => $columnDefs,
            'rows' => $rows
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
        $mode_action = 'create';
        $name = ['User Levels', 'Create'];
        $mode = [route('user_levels.index'), route('user_levels.create')];

        $this->audit_trail_logs('','','Creating new record','');

        $nav = $this->nav->whereIn('nav_type', ['single', 'main'])->orderBy('nav_order', 'asc')->get();
        foreach($nav as $key => $value){
            if ($value['nav_type'] == "main"){
                $value['sub'] = $this->nav->where('nav_childs_parent_id', $value['id'])->orderBy('nav_suborder', 'asc')->get();
            }               
        }

        return view('pages.user_levels.create', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'nav' => $nav,
            'title' => 'User Levels'
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
        // return $request->all();
        $validated = $this->validator($request);

        $this->userLevel->insert([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'description' => $validated['description'],
            'modules' => @implode(',', $request->input('allow-modules')),
            'sub_modules' => @implode(',', $request->input('allow-submodules')),
            'create' => @implode(',', $request->input('create')),
            'edit' => @implode(',', $request->input('edit')),
            'delete' => @implode(',', $request->input('delete')),
            'import' => @implode(',', $request->input('import')),
            'export' => @implode(',', $request->input('export')),
            'status' => $validated['status'],
            'created_by' => Auth::id(),
            'created_at' => now()
        ]);

        $this->audit_trail_logs('', 'created', 'user level: '.$validated['name'], $this->userLevel->id);

        return redirect()->route('user_levels.index')->with('success', 'You have successfully added '.$validated['name']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->userLevel->findOrFail($id);   
        $data->delete();

        $this->audit_trail_logs('', 'deleted', 'user_levels '.$data->name, $id);
        
        return redirect()->route('user_levels.index')
            ->with('success', 'You have successfully removed '.$data->name);
    }

    public function validator(Request $request)
    {
        $input = [
            'name' => $this->safeInputs($request->input('name')),
            'code' => $this->safeInputs($request->input('code')),
            'description' => $this->safeInputs($request->input('description')),
            // 'modules' => $this->safeInputs($request->input('allow-modules')),
            // 'sub_modules' => $this->safeInputs($request->input('allow-submodules')),
            // 'create' => $this->safeInputs($request->input('create')),
            // 'edit' => $this->safeInputs($request->input('edit')),
            // 'delete' => $this->safeInputs($request->input('delete')),
            // 'import' => $this->safeInputs($request->input('import')),
            // 'export' => $this->safeInputs($request->input('export')),
            'status' => $this->safeInputs($request->input('status'))
        ];

        $rules = [
            'name' => 'required|string|max:255|unique:user_levels,name,'.$this->safeInputs($request->input('id')),
            'code' => 'required|string|max:255|unique:user_levels,code,'.$this->safeInputs($request->input('id')),
            'description' => 'required|string',
            // 'modules.*' => 'required|string',
            // 'sub_modules.*' => 'required|string',
            // 'create.*' => 'required|string',
            // 'edit.*' => 'required|string',
            // 'delete.*' => 'required|string',
            // 'import.*' => 'required|string',
            // 'export.*' => 'required|string',
            'status' => 'required|numeric'
        ];

        $messages = [];

        $customAttributes = [
            'name' => 'name',
            'code' => 'code',
            'description' => 'description',
            // 'modules' => 'module',
            // 'sub_modules.*' => 'sub module',
            // 'create.*' => 'create',
            // 'edit.*' => 'edit',
            // 'delete.*' => 'delete',
            // 'import.*' => 'import',
            // 'export.*' => 'export',
            'status' => 'status',
        ];                

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    }
}
