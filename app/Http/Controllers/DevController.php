<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index(Request $request)
    {
        dd($request);
    }
}
