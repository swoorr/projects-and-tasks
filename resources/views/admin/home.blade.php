@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <div class="p-6">
        <h1 class="text-2xl font-bold">Welcome to the Admin Dashboard</h1>
    </div>


    <div class="mx-6 lg:mx-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2">Projects</h2>
            <p class="text-3xl font-bold">{{ \App\Models\Projects::count() }}</p>
            <a href="{{ route('admin.projects') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Manage Projects
            </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2">Tasks</h2>
            <p class="text-3xl font-bold">{{ \App\Models\Tasks::count() }}</p>
            <a href="{{ route('admin.home') }}" class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Manage Tasks
            </a>
        </div>
    </div>

    </div>



</div>
@endsection
