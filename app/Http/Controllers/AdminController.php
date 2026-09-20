<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        $menu = 'home';
        $submenu = '';

        return view('admin.home', compact('menu', 'submenu'));
    }

    public function adminusers()
    {
        $menu = 'users';
        $submenu = 'admin';

        return view('admin.admin-users', compact('menu', 'submenu'));
    }
}
