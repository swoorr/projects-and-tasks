<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Services\ProjectsServices;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    // construct project service
    protected $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectsServices();
    }

    public function index()
    { /* ... */
    } // {{ edit_1 }}
    public function store(Request $request)
    {
        $this->projectService->createProject($request->all());
        return response()->json(['success' => true, 'message' => 'Project created successfully']);
    } // {{ edit_2 }}
    public function show($id)
    { /* ... */
    } // {{ edit_3 }}
    public function update(Request $request, $id)
    { /* ... */
    } // {{ edit_4 }}
    public function destroy($id)
    { /* ... */
    } // {{ edit_5 }}
}
