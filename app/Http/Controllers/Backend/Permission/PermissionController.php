<?php

namespace App\Http\Controllers\Backend\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        return view('backend.permission.permission');
    }

    public function roles(){
        return view('backend.permission.roles');
    }
}
