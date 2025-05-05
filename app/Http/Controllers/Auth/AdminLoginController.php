<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $req)
    {
        $credentials = $req->only('username','password');
        if(Auth::guard('admin')->attempt($credentials)){
            return redirect()->intended(route('admin.dashboard'));
        }
        return back()->withErrors(['username'=>'Credensial tidak cocok']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
