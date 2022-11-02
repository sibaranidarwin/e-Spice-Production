<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login-user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {   
        $input = $request->all();
  
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->level == "accounting") {
                return redirect()->route('accounting/dashboard');

            }elseif(auth()->user()->level == "admin"){
                return redirect()->route('admin/dashboard');
            }
            elseif(auth()->user()->level == "vendor"){
                return redirect()->route('vendor/dashboard');
            }
            elseif(auth()->user()->level == "procurement"){
                return redirect()->route('procurement/dashboard');
            }
            elseif(auth()->user()->level == "warehouse"){
                return redirect()->route('warehouse/dashboard');
            }
            else{
                return redirect()->route('login-user')->with('destroy','Email And Password Are Wrong!');
            }
        }else{
            return redirect('login-user')->with('destroy','Email And Password Are Wrong!');
        }
          
    }
}
