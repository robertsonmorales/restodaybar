<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator, Arr, Auth;

class TableManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->changeValue($this->tableManagement->latest()->get());

        $columnDefs = array(            
            array('headerName'=>'Name','field'=>'name'),
            array('headerName'=>'No. of Seats','field'=>'no_seats'),
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

        $this->tableManagement->create($validated);

        $this->audit_trail_logs($request->all());

        return $this->redirectToIndex();
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
        $data = $this->tableManagement->findOrFail($id);
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

        $data = $this->tableManagement->find($id)->update($validated);

        $this->audit_trail_logs($request->all());

        return $this->redirectToIndex();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->tableManagement->findOrFail($id)->delete();

        $this->audit_trail_logs();

        return redirectToIndex();
    }

    public function validator(Request $request)
    {
        $input = [
            'name' => $this->safeInputs($request->input('name')),
            'no_seats' => $this->safeInputs($request->input('no_seats')),
            'status' => $this->safeInputs($request->input('status'))
        ];

        $rules = [
            'name' => 'required|string|unique:table_management,name,'.$this->safeInputs($request->input('id')),
            'no_seats' => 'required|numeric',
            'status' => 'required|numeric'
        ];

        $messages = [];

        $customAttributes = [
            'name' => 'name',
            'no_seats' => 'no_seats',
            'status' => 'status'
        ];

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    }
}
