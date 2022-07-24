<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function index(Request $request)
    {
        return view('auth.adminlogin');
    }

    public function login(LoginRequest $request)
    {
        // $validated = $request->validated();
        $inputVal = $request->all();

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'is_active' => '1',
            'email_verified' => '1'
        ];
        $credentials_1 = array_merge(['role_id' => 1], $credentials); // Masteradmin role
        $credentials_2 = array_merge(['role_id' => 2], $credentials); // Admin role
        $credentials_3 = array_merge(['role_id' => 3], $credentials); // SubAdmin role
        $remember_me = (isset($inputVal['remember']) && $inputVal['remember'] == 'on') ? true : false;
        $responseData = [];
        if (Auth::guard('admin')->attempt($credentials_1)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = route('admin.dashboard');
            return response()->json($responseData);
        } else if (Auth::guard('admin')->attempt($credentials_2)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = route('admin.dashboard');
            return response()->json($responseData);
        } else if (Auth::guard('admin')->attempt($credentials_3)) {
            $responseData['status'] = 200;
            $responseData['message'] = 'Success';
            $responseData['url'] = route('admin.dashboard');
            return response()->json($responseData);
        } else {
            // return redirect()->route('admin.login')->with('error','Email & Password are incorrect.');
            // return redirect()->back()->with('error','Email & Password are incorrect.');
            if ($request->ajax()) {
                $responseData['status'] = 0;
                $responseData['message'] = 'Email & Password are incorrect.';
                $responseData['url'] = route('admin.login');
                return response()->json($responseData);
            }
        }
        return redirect()->route('admin.login')->withInput()->withErrors('Email & Password are incorrect.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}