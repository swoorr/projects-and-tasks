<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Services\ProjectsServices;
use App\Services\TasksServices;
use Illuminate\Http\Request;

class TasksController extends Controller
{


    protected $taskService;

    public function __construct()
    {
        $this->taskService = new TasksServices();
    }

    public function index()
    {
        $tasks = Tasks::all();
        return response()->json(['success' => true, 'message' => 'Tasks retrieved successfully', 'data' => $tasks]);
    }
    public function store(Request $request)
    {
        $task = $this->taskService->createTask($request->all());
        return response()->json(['success' => true, 'message' => 'Task created successfully', 'data' => $task]);
    }
    public function show($id)
    {
        $task = $this->taskService->getTaskById($id);
        return response()->json(['success' => true, 'message' => 'Task retrieved successfully', 'data' => $task]);
    }
    public function update(Request $request, $id)
    {
        $task = $this->taskService->updateTask($id, $request->all());
        return response()->json(['success' => true, 'message' => 'Task updated successfully', 'data' => $task]);
    }
    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
    }
}
