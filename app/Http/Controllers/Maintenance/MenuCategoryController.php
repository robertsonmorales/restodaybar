<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\AuditLogTraits;

use Validator, Arr, Auth;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $rows = $this->category->latest()->get();
        $rows = $this->changeValue($rows);

        $columnDefs = array(            
            array('headerName'=>'Name','field'=>'name'),
            array('headerName'=>'Icon','field'=>'icon'),
            array('headerName'=>'Color Tag','field'=>'color_tag'),
            array('headerName' => 'Status', 'field' => 'status'),
            array('headerName' => 'Created By', 'field' => 'created_by'),
            array('headerName' => 'Created At', 'field' => 'created_at'),
            array('headerName' => 'Updated By', 'field' => 'updated_by'),
            array('headerName' => 'Updated At', 'field' => 'updated_at')
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
        $this->audit_trail_logs();

        $params = [ 'mode' => 'create' ];

        return $this->formView($params);
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
        // params here
        $data = $this->category->findOrFail($id);
        // ends here

        $this->audit_trail_logs();

        $params = [
            'mode' => 'update',
            'data' => $data
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

        return redirect()
            ->route('menu_categories.index')
            ->with('success', 'Menu Category Deleted Successfully!');
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
            'icon' => 'nullable|string|unique:menu_categories,icon,'.$this->safeInputs($request->input('id')),
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
