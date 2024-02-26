<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(Auth::check()){
            $user = Auth::user();
            if($user->role == 1){
                return redirect('/admin/accueil');
            }
            else{
                return redirect('/employe/accueil');
            }
        }
        return view('login');
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::attempt($credentials)){
            $user_role=Auth::user()->role;
            switch($user_role){
                case 0:
                    return redirect('/employe/accueil');
                    break;
                case 1:
                    return redirect('/admin/accueil');
                    break;
                default:
                    Auth::logout();
                    return back()->with('false','oops something went wrong');
            }
        }else{
            return back()->with('false','The credentials do not match our records');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
