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
    {

        $filter = request()->only(['projectName', 'projectStatus']);

        $projects = $this->projectService->getAllProjects($filter);
        return response()->json(['success' => true, 'message' => 'Projects retrieved successfully', 'data' => $projects]);
    }
    public function store(Request $request)
    {
        $this->projectService->createProject($request->all());
        return response()->json(['success' => true, 'message' => 'Project created successfully']);
    }
    public function show($id)
    {
        $project = $this->projectService->getProjectById($id);
        return response()->json(['success' => true, 'message' => 'Project retrieved successfully', 'data' => $project]);
    }
    public function update(Request $request, $id)
    {
        $this->projectService->updateProject($id, $request->all());
        return response()->json(['success' => true, 'message' => 'Project updated successfully']);
    }
    public function destroy($id)
    {
        $this->projectService->deleteProject($id);
        return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
    }
}
