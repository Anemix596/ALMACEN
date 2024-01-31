<?php

namespace App\Http\Controllers;

use App\Models\Vista;
use Illuminate\Http\Request;

class VistaController extends Controller
{
    
    public function index()
    {
        return view('auth.login');
    }
}
