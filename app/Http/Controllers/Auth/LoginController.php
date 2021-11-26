<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** 21/11/23
     * Author: ogasawara
     * forceFill()...requestされたユーザーのapi_tokenを強制的に書き換え
     * sessionに'api_token'で保持
     *  **/
    protected function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
          
        if(Auth::attempt($credentials)){
        // login処理が終わったらtokenを発行
            $token = Str::random(80);
            $request->user()->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
            session()->put('api_token', $token);              
            return response()->json(['message' => 'ログインに成功'],200);
        } else {
            return response()->json(['message' => 'メールアドレス・パスワードが一致しません'],401);
        }

    }
    


}
