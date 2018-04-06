<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
{
    public function index()
    {
        return view('vue.index');
    }

    public function auth()
    {
        return view('vue.auth');
    }

    public function admin()
    {
        return view('vue.admin');
    }
}