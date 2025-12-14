<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Customer Dashboard
     */
    public function customer()
    {
        return view('dashboard.customer');
    }

    /**
     * Developer Dashboard
     */
    public function developer()
    {
        return view('dashboard.developer');
    }

    /**
     * Admin Dashboard
     */
    public function admin()
    {
        return view('dashboard.admin');
    }
}

