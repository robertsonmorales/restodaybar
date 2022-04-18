<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Auth, Artisan, Route, Gate, Arr, Str;

use Purifier;

use App\Models\{User, UserLevel, AuditTrailLogs, 
    MenuCategory, MenuSubcategory, CategoryOfMenu,
    Menu, TableManagement, ApiLog,
    Navigation, UserBrowserSession};

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user, $userLevel, $auditLogs,
        $category, $subcategory, $categoryMenu,
        $menu, $tableManagement, $apiLog, $nav,
        $browserSession;

    public function __construct(User $user, UserLevel $userLevel,
        AuditTrailLogs $auditLogs, MenuCategory $category,
        MenuSubcategory $subcategory, CategoryOfMenu $categoryMenu, Menu $menu,
        TableManagement $tableManagement, ApiLog $apiLog,
        Navigation $nav, UserBrowserSession $browserSession){

        config('app.timezone', 'Manila/Asia');

        $this->user = $user;
        $this->userLevel = $userLevel;
        $this->auditLogs = $auditLogs;
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->categoryMenu = $categoryMenu;
        $this->menu = $menu;
        $this->tableManagement = $tableManagement;
        $this->apiLog = $apiLog;
        $this->nav = $nav;
        $this->browserSession = $browserSession;

        $this->route = $this->get()['route'];
        $this->title = $this->get()['title'];
    }

    // get routes and modules
    public function get(){
        $route = Route::getFacadeRoot()->current()->uri();
        $title = ucfirst(explode('/', $route)[0]);

        $explodeTitle = explode('_', $title);

        $newTitle = "";
        for ($i=0; $i < count($explodeTitle); $i++) { 
            $newTitle .= ucfirst($explodeTitle[$i]) ." ";
        }

        return array(
            'route' => $route,
            'title' => $newTitle
        );
    }

    // index page view
    public function indexView($data){
        $route = $this->route;
        $view = 'pages.'.$route.'.index'; // index page
        $form = $route.'.create'; // form page

        $pagesize = $this->pagesize();

        $params = array(
            'breadcrumbs' => $this->breadcrumbs([$this->title], [$route]),
            'data' => $data,
            'pagesize' => $pagesize,
            'create' => $form,
            'title' => $this->title,
            'icon_for' => $this->controlIcons()
        );

        return view($view, $params);
    }

    // index page redirection
    public function redirectToIndex(){
        $route = explode('/', $this->route)[0];
        return redirect()->route($route.'.index')
            ->with('success', 'New Record Added Successfully!'); // $this->title.
    }

    // form view
    public function formView($params){
        // $name = ['Menus', 'Create'];
        // $mode = [route('menus.index'), route('menus.create')];
        
        $module = explode('/', $this->get()['route'])[0];
        $view = 'pages.'.$module.'.form';

        $url = ($params['mode'] == 'update') 
            ? route($module.'.update', $params['data']->id)
            : route($module.'.store');

        $title = $this->get()['title'];

        // add to params here
        $params['title'] = $title;
        $params['subtitle'] = $this->singular($params['mode'], $title);
        $params['url'] = $url;

        // ! NEEDS FIXING
        $params['breadcrumbs'] = $this->breadcrumbs([$this->title], [$this->route]);
        // ends here

        return view($view, $params);
    }

    // IP Address
    public function ipAddress(){
        $_ipAddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $_ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $_ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $_ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $_ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $_ipAddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $_ipAddress = $_SERVER['REMOTE_ADDR'];
        else
            $_ipAddress = 'UNKNOWN';

        return $_ipAddress;
    }

    // audit trails
    public function audit_trail_logs($remarks = null){
        $route = Route::getFacadeRoot()->current()->uri();
        $module = strtoupper(explode('/', $route)[0]); // GET MODULE
        $method = $_SERVER['REQUEST_METHOD'];
        $ipAddress = $this->ipAddress();
        $remarks = ($remarks == null) ? json_encode(array("message" => "VIEWING " . $module)) : json_encode($remarks);
        
        if(strlen(exec('getmac')) > 17){
            $device = "";
        }else{
            $device = exec('getmac');
        }

        $result = array(
            'route' => $route,
            'module' => $module,
            'method' => $method,
            'user_id' => Auth::id(),
            'remarks' => $remarks,
            'ip' => $ipAddress,
            'device' => $device
        );

        AuditTrailLogs::create($result);
    }

    public function apiLog($data, $params = null){
        $method = $_SERVER['REQUEST_METHOD'];
        $route = Route::getFacadeRoot()->current()->uri();

        if(exec('getmac') == "N/A Media disconnected"){
            $device = exec('getmac');
        }else{
            $device = "";
        }

        $result = array(
            'method' => $method,
            'api' => $route,
            'params' => $params,
            'response' => $data,
            'ip' => $this->ipAddress(),
            'device' => $device
        );
        
        $this->apiLog->create($result);
    }
    
    // Breadcrumbs
    public function breadcrumbs($name, $mode){
        return array(
            'name' => $name,
            'mode' => $mode
        );
    }

    // Preset page size
    public function pageSize(){
        return array(
            'default' => 25,
            'options' => [25, 50, 75, 100, 250, 500]
        );
    }

    // Sanitizer
    public function safeInputs($input){
        return Purifier::clean($input, [
            'HTML.Allowed' => ''
        ]);
    }

    public function changeValue($rows){
        foreach ($rows as $key => $value) {
    
            if(Arr::exists($value, 'status')){
                 if($value->status == 1){
                    $value->status = 'Active';
                 }else{
                    $value->status = 'In-active';
                 }
            }

            if(Arr::exists($value, 'created_by')){
                $users = User::find($value['created_by']);
                $value['created_by'] = @$users->username;
            }

            if(Arr::exists($value, 'updated_by')){
                $users = User::find($value['updated_by']);
                $value['updated_by'] = @$users->username;
            }
        }

        return $rows;
    }

    // generate controller and model for navigation
    public function generateResourceFiles($model, $controller, $route, $folder=''){
        $controller = $folder.'/'.$controller.'Controller';

        Artisan::queue('make:controller', [
            'name' => $controller, 
            '--resource' => $controller
        ]);

        Artisan::queue('make:model', [
            'name' => $model, 
            '-m' => $model
        ]);

        Artisan::queue('make:view', [
            'name' => $route
        ]);
    }

    // image upload
    public function uploadImage($data, $path, $width, $height){
        if ($data->isValid()) {
            $publicFolder = $path;
            $profileImage = $data->getClientOriginalName(); // returns original name
            $extension = $data->getclientoriginalextension(); // returns the file extension
            $newProfileImage = strtoupper(Str::random(12)).'.'.$extension;
            $move = $data->storeAs($publicFolder, $newProfileImage);
            
            if ($move) {
                return $newProfileImage;
            }
        }
    }

    // icons in index page
    public function controlIcons(){
        return array(
            'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
            'remove' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'
        );
    }

    // use to make singular terms
    public function singular($mode, $title){
        return ucfirst($mode).' '.\Str::Singular($title);
    }
}
