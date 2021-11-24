<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            return response()->json(['message' => 'ログインに成功しました'],200);
        } else {
            return response()->json(['message' => 'メールアドレス,またはパスワードが一致しません'],401);
        }

        // login処理が終わったらtokenを発行
        $token = Str::random(80);
        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        session()->put('api_token', $token);
    }


}
