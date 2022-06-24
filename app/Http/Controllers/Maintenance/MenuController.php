<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator, Arr, Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->changeValue($this->menu->latest()->get());

        $columnDefs = array(
            array('headerName' => 'Name', 'field' => 'name'),
            // array('headerName' => 'Image Source', 'field' => 'img_src'),
            array('headerName' => 'Price', 'field' => 'price'),
            array('headerName' => 'Process by cook', 'field' => 'is_processed_by_cook'),
            array('headerName' => 'Inventoriable', 'field' => 'is_inventoriable'),
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

    public function create()
    {
        // params here
        $categories = $this->category->select('id', 'name')->active()->ascendingName()->get();
        $subcategories = $this->subcategory->select('id', 'menu_category_id', 'name')->active()->ascendingName()->get();
        // ends here

        $this->audit_trail_logs();

        $params = [
            'mode' => 'create',
            'categories' => $categories,
            'subcategories' => $subcategories
        ];

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

        $categoryMenuId = $this->categoryMenu->create(array(
            'menu_category_id' => $validated['menu_category_id'],
            'menu_subcategory_id' => $validated['menu_subcategory_id'],
            'created_by' => $validated['created_by']
        ))->id;

        if(!empty($categoryMenuId)){
            unset($validated['menu_category_id']);
            unset($validated['menu_subcategory_id']);

            $path = ('images/menus');
            $validated['category_menu_id'] = $categoryMenuId;
            $validated['img_src'] = $this->uploadImage($validated['img_src'], $path, '', '');

            $this->menu->create($validated);
        }

        $this->audit_trail_logs($request->all());

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu Added Successfully!');
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
        $data = $this->menu->find($id);
        dd($this->menu->findOrFail($id)->categoryMenu);
        
        $categories = $this->category->select('id', 'name')->active()->ascendingName()->get();
        $subcategories = $this->subcategory->select('id', 'menu_category_id', 'name')->active()->ascendingName()->get();
        // ends here

        $this->audit_trail_logs();

        $params = [
            'mode' => 'update',
            'data' => $data,
            'categories' => $categories,
            'subcategories' => $subcategories
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
        $data = $this->menu->findOrFail($id);

        $validated = $this->validator($request);
        $validated['updated_by'] = Auth::id();

        $categoryMenu = $this->categoryMenu->find($data->category_menu_id);
        $categoryMenuId = $categoryMenu->id;
        $categoryMenu->update([
            'menu_category_id' => $validated['menu_category_id'],
            'menu_subcategory_id' => $validated['menu_subcategory_id'],
            'updated_by' => $validated['updated_by']
        ]);

        unset($validated['menu_category_id']);
        unset($validated['menu_subcategory_id']);

        $path = ('images/menus');
        $validated['category_menu_id'] = $categoryMenuId;
        $validated['img_src'] = (is_null($validated['img_src'])) 
            ? $data->img_src : $this->uploadImage($validated['img_src'], $path, '', '');

        $data->update($validated);

        $this->audit_trail_logs($request->all());

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->menu->findOrFail($id)->delete();

        $this->audit_trail_logs();

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu Deleted Successfully!');
    }

    public function validator(Request $request)
    {
        $input = [
            'img_src' => $request->file('img_src'),
            'menu_category_id' => $this->safeInputs($request->input('category')),
            'menu_subcategory_id' => $this->safeInputs($request->input('subcategory')),
            'name' => $this->safeInputs($request->input('name')),
            'price' => $this->safeInputs($request->input('price')),
            'is_processed_by_cook' => $this->safeInputs($request->input('is_processed_by_cook')),
            'is_inventoriable' => $this->safeInputs($request->input('is_inventoriable')),
            'status' => $this->safeInputs($request->input('status'))
        ];

        $rules = [
            'img_src' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'menu_category_id' => 'required|numeric',
            'menu_subcategory_id' => 'nullable|numeric',
            'name' => 'required|string|unique:menus,name,'.$this->safeInputs($request->input('id')),
            'price' => 'required|numeric',
            'is_processed_by_cook' => 'nullable',
            'is_inventoriable' => 'nullable',
            'status' => 'required|numeric'
        ];

        $messages = [];

        $customAttributes = [
            'img_src' => 'image',
            'menu_category_id' => 'category',
            'menu_subcategory_id' => 'subcategory',
            'name' => 'name',
            'price' => 'price',
            'is_processed_by_cook' => 'processed by cook',
            'is_inventoriable' => 'inventoriable',
            'status' => 'status'
        ];

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    }
}
