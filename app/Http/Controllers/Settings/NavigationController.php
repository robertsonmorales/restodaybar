<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, Validator, Str;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->nav->mainAndSingle()->oldest('nav_name')->get();
        $rows = $this->changeValue($rows);

        $columnDefs = array(
            array('headerName'=>'Name','field'=>'nav_name', 'floatingFilter'=> false),
            array('headerName'=>'Type','field'=>'nav_type', 'floatingFilter'=> false),
            array('headerName'=>'Route','field'=>'nav_route', 'floatingFilter'=> false),
            array('headerName'=>'Controller','field'=>'nav_controller', 'floatingFilter'=> false),
            array('headerName'=>'Status','field'=>'status', 'floatingFilter'=>false),
            array('headerName'=>'Created By','field'=>'created_by', 'floatingFilter'=>false),
            array('headerName'=>'Updated By','field'=>'updated_by', 'floatingFilter'=>false),
            array('headerName'=>'Created At','field'=>'created_at', 'floatingFilter'=>false),
            array('headerName'=>'Updated At','field'=>'updated_at', 'floatingFilter'=>false)
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
        $mode_action = 'create';
        $name = ['Navigations', 'Create'];
        $mode = [route('navigations.index'), route('navigations.create')];

        $this->audit_trail_logs();

        return view('pages.navigations.create', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Navigations'
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
        $getLastOrder = $this->nav
            ->mainAndSingle()
            ->activeNav()
            ->latest('nav_order')
            ->first();

        $type = $validated['nav_type'];
        $controller = $this->adjustModelController($validated['nav_controller']);

        // MUTATORS
        $validated['nav_controller'] = ($validated['nav_type'] == "main") ? null : $controller;
        $validated['nav_route'] = $this->adjustRoute($validated['nav_route']);
        $validated['nav_order'] = $getLastOrder['nav_order'] + 1;
        $validated['created_by'] = Auth::id();
        // ENDS HERE

        $navId = $this->nav->create($validated)->id; // INSERT OR CREATE

        $parent_id = $navId;
        if($validated['nav_type'] == "single"){
            $model = $this->adjustModelController($validated['nav_name']);
            $route = $validated['nav_route'];

            $this->generateResourceFiles($model, $controller, $route);
        }else if ($validated['nav_type'] == "main"){
            $rows = $this->safeInputs($request->input('rows'));

            $validated_sub = array();
            for ($i=0; $i < $rows; $i++) {
                $sub_name = $validated['sub_name'][$i];
                $sub_controller = $this->adjustModelController($validated['sub_controller'][$i]);
                $sub_route = $this->adjustRoute($validated['sub_route'][$i]);
                $sub_order = $validated['sub_order'][$i];

                $navName = $this->adjustModelController($validated['nav_name']);
                $model = $this->adjustModelController($sub_name);
                
                $validated_sub['nav_type'] = 'sub';
                $validated_sub['nav_name'] = $sub_name;
                $validated_sub['nav_controller'] = $navName.'\\'.$sub_controller;
                $validated_sub['nav_route'] = $sub_route;
                $validated_sub['nav_icon'] = 'circle';
                $validated_sub['nav_suborder'] = $sub_order;
                $validated_sub['nav_childs_parent_id'] = $parent_id;
                $validated_sub['status'] = 1;
                $validated_sub['created_by'] = Auth::id();

                $insert_nav = $this->nav->create($validated_sub);

                if($insert_nav){
                    $this->generateResourceFiles($model, $sub_controller, $sub_route, $navName);
                }
            }
        }

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
        $data = $this->nav->findOrFail($id);
        $sub = @$this->nav->where(array(
            'nav_type' => 'sub',
            'nav_childs_parent_id' => $data->id,
            'status' => 1,
        ))->get();

        $rows = @$sub->count();
    
        $mode_action = 'update';
        $name = ['Navigations', 'Edit', $data->name];
        $mode = [route('navigations.index'), route('navigations.edit', $id), route('navigations.edit', $id)];

        $this->audit_trail_logs();

        return view('pages.navigations.create', [
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Navigations',
            'data' => $data,
            'sub' => $sub,
            'rows' => $rows,
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
        $data = $this->nav->findOrFail($id);
        $data->delete();

        $this->audit_trail_logs();
        
        return redirect()->route('navigations.index')
            ->with('success', 'You have successfully removed '.$data->nav_name);
    }

    public function adjustModelController($string){
        return str_replace(' ', '', ucwords(Str::singular($string)));
    }

    public function adjustRoute($string){
        return str_replace(' ', '_', strtolower(Str::plural($string)));
    }

    public function validator(Request $request){
        $type = $this->safeInputs($request->input('type'));
        $mode_main = ($type == "main") ? "nullable" : "required";
        $mode_single = ($type == "single") ? "nullable" : "required";

        $input = [
            'nav_name' => $this->safeInputs($request->input('name')),
            'nav_controller' => $this->safeInputs($request->input('controller')),
            'nav_route' => $this->safeInputs($request->input('route')),
            'nav_icon' => $this->safeInputs($request->input('icon')),
            'nav_type' => $this->safeInputs($request->input('type')),
            'status' => $this->safeInputs($request->input('status')),

            'sub_name' => $this->safeInputs($request->input('sub_name')),
            'sub_route' => $this->safeInputs($request->input('sub_route')),
            'sub_controller' => $this->safeInputs($request->input('sub_controller')),
            'sub_order' => $this->safeInputs($request->input('sub_order')),
        ];

        $rules = [
            'nav_name' => 'required|string|max:255|unique:navigations,nav_name,'.$this->safeInputs($request->input('id')),
            'nav_controller' => $mode_main.'|max:100|unique:navigations,nav_controller,'.$this->safeInputs($request->input('id')),
            'nav_route' => $mode_main.'|max:50|unique:navigations,nav_route,'.$this->safeInputs($request->input('id')),
            'nav_icon' => 'required|max:50|unique:navigations,nav_icon,'.$this->safeInputs($request->input('id')),
            'nav_type' => 'required|string',
            'status' => 'required|numeric',

            'sub_name.*' => $mode_single.'|string',
            'sub_route.*' => $mode_single.'|string',
            'sub_controller.*' => $mode_single.'|string',
            'sub_order.*' => $mode_single.'|string',
        ];

        $messages = [];

        $customAttributes = [
            'nav_name' => 'name',
            'nav_controller' => 'controller',
            'nav_route' => 'route',
            'nav_icon' => 'icon',
            'nav_type' => 'type',
            'status' => 'status',

            'sub_name' => 'sub-name',
            'sub_route' => 'sub-route',
            'sub_controller' => 'sub-controller',
            'sub_order' => 'sub-order',
        ];                

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    }
}