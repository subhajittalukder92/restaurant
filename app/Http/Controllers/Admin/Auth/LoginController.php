<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Auth;
use Redirect;
use Carbon\Carbon;


class LoginController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'admin/customers';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }
    
    //Login Page
    public function showloginPage(){
        return view('admin.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
          ]);
    
          $credentials = $request->only('email', 'password');
          $adminUser = User::where('email',$request->email)->value('role_id');
          $adminRoleId = 2;

            if(in_array($adminUser, [$adminRoleId]))
            {
                if(\Auth::attempt($credentials, true)) {
                    return redirect()->route('admin.customers.index');
                }
            }
            return redirect()->route('admin.login')->withErrors(['email' => 'Invalid Username/password.']);
    }
    
    public function logout(Request $request)
    {
      Auth::logout(); // log the user out of our application
     //$this->guard()->logout();
      $request->session()->invalidate();
      return Redirect::to('/admin/login'); // redirect the user to the login screen
    }
}
