<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function home()
    {
        return view('admin.home');
    }

    // Projects
    public function projects()
    {

        $projects = Projects::all();

        return view('admin.projects', compact('projects'));
    }

}
