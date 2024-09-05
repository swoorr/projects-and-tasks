<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\Tasks;
use App\Services\ProjectsServices;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectsServices();
    }

    public function home()
    {
        return view('admin.home');
    }

    // Projects
    public function projects()
    {

        $projects = $this->projectService->getAllProjects(request()->all());

        return view('admin.projects', compact('projects'));
    }

    public function project($id)
    {
        $project = Projects::find($id);
        $tasks = Tasks::where('project_id', $id)->get();
        return view('admin.project', compact('project', 'tasks'));
    }

}
