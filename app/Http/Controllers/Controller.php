<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Auth;
use DB;
use Crypt;
use Hash;
use Validator;
use Artisan;
use Route;
use Gate;
use Arr;
use Str;
use Carbon\Carbon;

use App\Models\User;
use App\Models\AuditTrailLogs;

use Purifier;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    public function __construct(User $user){
        $this->user = $user;
    }

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

    public function audit_trail_logs($remarks = null){
        $route = Route::getFacadeRoot()->current()->uri();
        $module = strtoupper(explode('/', $route)[0]); // GET MODULE
        $method = $_SERVER['REQUEST_METHOD'];
        $username = Auth::check() ? Auth::user()->username : 'Unathorized';
        $ipAddress = $this->ipAddress();
        $remarks = ($remarks == null) ? json_encode(array("message" => "VIEWING " . $module)) : json_encode($remarks);

        AuditTrailLogs::create([
            'route' => $route,
            'module' => $module,
            'method' => $method,
            'username' => $username,
            'remarks' => $remarks,
            'ip' => $ipAddress
        ]);
    }
    
    public function breadcrumbs($name, $mode){
        return $breadcrumb = array(
            'name' => $name,
            'mode' => $mode
        );
    }

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
                // array(
                //     'username' => @$users->username,
                //     'profile_image' => @$user->profile_image
                // );
            }

            if(Arr::exists($value, 'updated_by')){
                $users = User::find($value['updated_by']);
                $value['updated_by'] = @$users->username;
                // array(
                //     'username' => @$users->username,
                //     'profile_image' => @$user->profile_image
                // );
            }
        }

        return $rows;
    }

    public function generateNavigationFiles($model, $controller, $type, $folder){
        $controller = $folder.'/'.$controller.'Controller';

        $makeController = Artisan::queue('make:controller', [
            'name' => $controller, 
            '--resource' => $controller
        ]);

        $makeModel = Artisan::queue('make:model', [
            'name' => $model, 
            '-m' => $model
        ]);
    }

    public function uploadImage($data, $path, $width, $height){
        if ($data->isValid()) {
            $publicFolder = $path;
            $profileImage = $data->getClientOriginalName(); // returns original name
            $extension = $data->getclientoriginalextension(); // returns the file extension
            $newProfileImage = strtolower(Str::random(20)).'-'.date('Y-m-d').'.'.$extension;
            $move = $data->storeAs($publicFolder, $newProfileImage);
            
            if ($move) {
                return $newProfileImage;
            }
        }
    }
}
