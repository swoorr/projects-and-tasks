<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index() { /* ... */ } // {{ edit_1 }}
    public function store(Request $request) { /* ... */ } // {{ edit_2 }}
    public function show($id) { /* ... */ } // {{ edit_3 }}
    public function update(Request $request, $id) { /* ... */ } // {{ edit_4 }}
    public function destroy($id) { /* ... */ } // {{ edit_5 }}
}
