<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\PasswordRequirement;

use Arr;
use Auth;
use Validator;

use App\Models\User;
use App\Models\UserLevel;
use Carbon\Carbon;

class UserAccountController extends Controller
{
    protected $user, $userLevel;

    public function __construct(User $user, UserLevel $userLevel){
        $this->user = $user;
        $this->userLevel = $userLevel;
    }

    public function validator(Request $request)
    {
        $input = [
            'first_name' => $this->safeInputs($request->input('first_name')),
            'last_name' => $this->safeInputs($request->input('last_name')),
            'email' => $this->safeInputs($request->input('email')),
            'username' => $this->safeInputs($request->input('username')),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
            'contact_number' => $this->safeInputs($request->input('contact_number')),
            'address' => $this->safeInputs($request->input('address')),
            'user_level_code' => $this->safeInputs($request->input('user_level_code')),
            'account_status' => $this->safeInputs($request->input('account_status'))
        ];

        $rules = [
            'first_name' => 'required|string|max:55',
            'last_name' => 'required|string|max:55',
            'email' => 'bail|required|email|max:100|unique:users,email',
            'username' => 'bail|required|string|max:30|unique:users,username',
            'password' => ['bail', 'required', 'string', 'min:8', 'max:30', 'confirmed', 'unique:users,password,'.$this->safeInputs($request->input('id')).'', new PasswordRequirement],
            'password_confirmation' => 'required|string',
            'contact_number' => 'required|numeric|digits:11',
            'address' => 'required|string',
            'user_level_code' => 'required|string',
            'account_status' => 'required|numeric',
        ];

        $messages = [];

        $customAttributes = [
            'first_name' => 'first name',
            'last name' => 'last name',
            'email' => 'email',
            'username' => 'username', 
            'password' => 'password',
            'contact_number' => 'contact number',
            'address' => 'address',
            'user_level_code' => 'user level',
            'account_status' => 'account status'
        ];

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = ['User Accounts'];
        $mode = [route('user_accounts.index')];
        
        $pagesize = [25, 50, 75, 100, 125];
        
        $rows = array();
        $rows = $this->user->where('id', '!=', Auth::id())->latest()->get();
        $rows = $this->changeValue($rows);
        $rows = $this->changeValue_v2($rows);

        $columnDefs = array(            
            array('headerName'=>'NAME','field'=>'name', 'floatingFilter'=>false),
            array('headerName'=>'USERNAME','field'=>'username', 'floatingFilter'=>false),
            array('headerName'=>'EMAIL','field'=>'email', 'floatingFilter'=>false),
            array('headerName'=>'CONTACT NUMBER','field'=>'contact_number', 'floatingFilter'=>false),
            array('headerName'=>'STATUS','field'=>'account_status', 'floatingFilter'=>false),
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

        return view('pages.user_accounts.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'data' => $data,
            'pagesize' => $pagesize,
            'create' => "user_accounts.create",
            'title' => 'User Accounts'
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
        $name = ['User Accounts', 'Create'];
        $mode = [route('user_accounts.index'), route('user_accounts.create')];

        $this->audit_trail_logs();

        $user_levels = @$this->userLevel->where('status', 1)->get();

        return view('pages.user_accounts.create', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'User Accounts',
            'user_levels' => $user_levels
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
        $data = $this->user->create($validated);

        $this->audit_trail_logs('', 'created', 'user_accounts: '.$validated['username'], $data['id']);

        return redirect()
            ->route('user_accounts.index')
            ->with('success', 'You have successfully added '.$validated['username']);
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
        $data = $this->user->findOrFail($id);

        $mode_action = 'update';
        $name = ['User Accounts', 'Edit', $data->username];
        $mode = [route('user_accounts.index'), route('user_accounts.edit', $id), route('user_accounts.edit', $id)];

        $this->audit_trail_logs('', '', 'user_accounts: '.$data->username, $id);
        $user_levels = @$this->userLevel->where('status', 1)->get();

        return view('pages.user_accounts.create', [            
            'mode' => $mode_action,
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'User Accounts',
            'user' => $data,
            'user_levels' => $user_levels
        ]);
    }

    public function updateValidator(Request $request){
        $input = [
            'first_name' => $this->safeInputs($request->input('first_name')),
            'last_name' => $this->safeInputs($request->input('last_name')),
            'address' => $this->safeInputs($request->input('address')),
            'account_status' => $this->safeInputs($request->input('account_status')),
        ];

        $rules = [
            'first_name' => 'required|string|max:55',
            'last_name' => 'required|string|max:55',
            'address' => 'required|string',
            'account_status' => 'required|numeric',
        ];

        $messages = [];

        $customAttributes = [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'address' => 'address',
            'account_status' => 'account status',
        ];

        $validator = Validator::make($input, $rules, $messages,$customAttributes);
        return $validator->validate();
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
        $validated = $this->updateValidator($request);
        if ($validated) {
            $data = $this->user->find($id);
            $data->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address' => $validated['address'],
                'user_level_code' => $validated['user_level_code'],
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);

            $this->audit_trail_logs($request->all());

            return redirect()->route('user_accounts.index')->with('success', 'You have successfully updated '.$data->username);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->user->findOrFail($id);
        $data->deleted_by = Auth::id();
        $save = $data->save();
        if ($save) {
            $data->delete();
        }

        $this->audit_trail_logs('', 'deleted', 'user_account '.$data->username, $id);

        return redirect()->route('user_accounts.index')->with('success', 'You have successfully removed '.$data->username);
    }

    public function changeValue_v2($rows){
        foreach ($rows as $key => $value) {
            $value['name'] = ucfirst($value['first_name']).' '.ucfirst($value['last_name']);

            // 1 = admin, 2 = cashier, 3 = manager, 4 = cook
            if (Arr::exists($value, 'account_status')) {
                if ($value->account_status == 1) {
                    $value->account_status = "Active";
                }elseif ($value->account_status == 2) {
                    $value->account_status = "Deactivate";
                }elseif ($value->account_status == 3) {
                    $value->account_status = "Lock";
                }
            }
        }

        return $rows;
    }
}
