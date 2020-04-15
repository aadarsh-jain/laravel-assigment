<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function setCookie(Request $request){
        $response = new Response('Set Cookie');
        $response->withCookie(cookie($request->key, $request->value, $request->minutes));
        return $response;
    }

    public function getCookie(Request $request){
        $value = $request->cookie($request->key);
        return $value;
    }
}
