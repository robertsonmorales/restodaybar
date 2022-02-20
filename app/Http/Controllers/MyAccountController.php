<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr, Str, Auth, Validator;

use App\Rules\PasswordRequirement;
use App\Rules\CheckCurrentPassword;
use App\Rules\ValidateOldToNewPassword;
use App\Rules\ValidateCurrentToNewPassword;
use App\Rules\CheckCurrentEmailAddress;

use App\Models\User;

class MyAccountController extends Controller
{
    public function validator(Request $request){
        $input = [
            'profile_image' => $request->file('profile_image'),
            'first_name' => $this->safeInputs($request->input('first_name')),
            'last_name' => $this->safeInputs($request->input('last_name')),
            'username' => $this->safeInputs($request->input('username')),
            'contact_number' => $this->safeInputs($request->input('contact_number')),
            'address' => $this->safeInputs($request->input('address'))
        ];

        $rules = [
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'first_name' => 'required|string|max:55',
            'last_name' => 'required|string|max:55',
            'username' => 'required|string|max:30|unique:users,username,'.Auth::id(),
            'contact_number' => 'required|min:11|max:13',
            'address' => 'required|string|max:255'
        ];

        $messages = [];

        $customAttributes = [
            'profile_image' => 'file',
            'first_name' => 'first name',
            'last_name' => 'last name',
            'username' => 'username',
            'contact_number' => 'contact number',
            'address' => 'address'
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
        $name = ['Account Settings', 'Profile Information'];
        $mode = [route('account_settings.index'), route('account_settings.index')];
        
        $action_mode = 'update';

        $profile = (is_null(auth()->user()->profile_image))
                    ? "https://ui-avatars.com/api/?background=0061f2&color=fff&name=".auth()->user()->first_name."&format=svg&bold=true&font-size=0.4&length=1"
                    : asset('uploads/user_accounts/'.auth()->user()->profile_image);

        $this->audit_trail_logs();
        
        return view('pages.account_settings.profile_information.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Profile Information',
            'mode' => $action_mode,
            'profile_image' => $profile
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
        $path = ('images/user_accounts');
        $validated = $this->validator($request);
        
        $data = $this->user->findOrFail($id);
        $validated['profile_image'] =  (is_null($validated['profile_image']))
            ? $data->profile_image
            : $this->uploadImage($validated['profile_image'], $path, '', '');
        $validated['profile_image_updated_at'] = now();
        $validated['profile_image_expiration_date'] = now()->addDays(60);
        $validated['ip'] = $this->ipAddress();
        $validated['updated_by'] = Auth::id();
        $data->update($validated);

        $this->audit_trail_logs($request->all());

        return back()->with('success', 'Profile Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->audit_trail_logs($request->all());

        $this->user->findOrFail($id)->delete();

        Auth::logout();
        return redirect('/login');
    }

    protected function email(){
        $name = ['Account Settings', 'Email'];
        $mode = [route('account_settings.index'), route('account_settings.email')];

        $this->audit_trail_logs();

        return view('pages.account_settings.email.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Email'
        ]);
    }

    protected function updateEmail(Request $request){
        $validated = $this->safeInputs($request->validate([
            'email' => ['required', 'string', 'email', 'unique:users,email,'.Auth::id().'', new CheckCurrentEmailAddress],
        ]));
        
        $validated['email_updated_at'] = now();
        $validated['updated_by'] = Auth::id();

        $this->user->findOrFail(Auth::id())->update($validated);

        $this->audit_trail_logs($request->all());

        return back()->with('success', 'Email Updated Successfully!');
    }

    protected function password(){
        $name = ['Account Settings', 'Password'];
        $mode = [route('account_settings.index'), route('account_settings.password')];

        $this->audit_trail_logs();

        return view('pages.account_settings.password.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Password'
        ]);
    }

    protected function updatePassword(Request $request){
        $validated = $request->validate([
            'current_password' => ['required', 'string', new CheckCurrentPassword],
            'password' => ['bail', 'required', 'string', 'unique:users,password,'.Auth::id(), 'confirmed', new PasswordRequirement, new ValidateOldToNewPassword, new ValidateCurrentToNewPassword],
            'password_confirmation' => ['required', 'string']
        ]);

        $validated['password_updated_at'] = now();
        $validated['password_expiration_date'] = now()->addDays(60);
        $validated['old_password'] = $validated['current_password'];
        
        $this->user->findOrFail(Auth::id())->update($validated);

        $this->audit_trail_logs($request->all());

        Auth::logout();
        $request->session()->flush();

        return redirect('/login')->with('success','Password Updated Successfully!');
    }

    protected function browserSessions(){
        $name = ['Account Settings', 'Browser Sessions'];
        $mode = [route('account_settings.index'), route('account_settings.browser_sessions')];

        $this->audit_trail_logs();

        $sessions = $this->browserSession->mySessions()->latest()->get();
        
        return view('pages.account_settings.browser_sessions.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),
            'title' => 'Browser Sessions',
            'sessions' => $sessions
        ]);
    }

    protected function logoutAllSessions(Request $request){
        $user = $this->user->find(Auth::id());

        $user->update([
            'remember_token' => null
        ]);

        $this->browserSession->where('user_id', Auth::id())->delete();

        Auth::logout();

        return redirect('/login')
            ->with('success','Logout All Sessions Successfully!');
    }

    protected function deleteAccount(){
        $name = ['Account Settings', 'Delete Account'];
        $mode = [route('account_settings.index'), route('account_settings.delete_account')];

        $this->audit_trail_logs();

        return view('pages.account_settings.delete_account.index', [
            'breadcrumbs' => $this->breadcrumbs($name, $mode),            
            'title' => 'Delete Account',
        ]);
    }
}
