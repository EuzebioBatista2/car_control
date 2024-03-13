<?php

namespace App\Http\Controllers;
class WelcomeController extends Controller
{
    public function index()
    {
        $auth = "login";

        if (auth()->check())
        {
            $auth = "home";
        }
        
        return view('welcome', ["auth" => $auth]);
    }
}
