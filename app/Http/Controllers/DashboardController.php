<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard berdasarkan role user
     */
    public function index()
    {
        return view('dashboard');
    }
}
