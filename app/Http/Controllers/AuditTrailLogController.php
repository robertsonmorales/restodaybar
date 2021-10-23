<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrailLogs;

class AuditTrailLogController extends Controller
{
    public function __construct(AuditTrailLogs $logs){
        $this->log = $logs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = ['Audit Trail Logs'];
        $mode = [route('audit_trail_logs.index')];

        $pagesize = [25, 50, 75, 100, 125];
        
        $rows = array();
        $rows = $this->log->latest()->get();

        $columnDefs = array(
            array('headerName'=>'MODULE','field'=>'module', 'floatingFilter'=> false),
            array('headerName'=>'ROUTE','field'=>'route', 'floatingFilter'=> false),
            array('headerName'=>'USERNAME','field'=>'username', 'floatingFilter'=>false),
            array('headerName'=>'METHOD','field'=>'method', 'floatingFilter'=>false),
            array('headerName'=>'REMARKS','field'=>'remarks', 'floatingFilter'=>false),
            array('headerName'=>'IP ADDRESS','field'=>'ip', 'floatingFilter'=>false),
            array('headerName'=>'CREATED AT','field'=>'created_at', 'floatingFilter'=>false)
        );

        $data = json_encode(array(
            'column' => $columnDefs,
            'rows' => $rows
        ));    

        $this->audit_trail_logs();
        
        return view('pages.audit_trail_logs.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'data' => $data,
            'pagesize' => $pagesize,
            'title' => 'Audit Trail Logs'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
