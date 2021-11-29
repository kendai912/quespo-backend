<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return response()->json(
            [
            'result' => "success!"
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
