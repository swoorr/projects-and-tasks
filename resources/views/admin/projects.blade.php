@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Projects</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                New Project
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Project Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $index => $project)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->status }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- New Project Modal -->
<div class="modal fade" id="newProjectModal" tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProjectModalLabel">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newProjectForm">
                    @csrf
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="projectDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="projectDescription" name="description" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitNewProject">Create Project</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#submitNewProject').click(function() {
            var formData = $('#newProjectForm').serialize();
            $.ajax({
                url: '{{ route("projects.store") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#newProjectModal').modal('hide');
                        location.reload(); // Reload the page to show the new project
                    } else {
                        alert('Error creating project');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        alert('Unauthorized. Please log in again.');
                        // Redirect to login page or handle re-authentication
                    } else {
                        alert('Error creating project');
                    }
                }
            });
        });
    });
</script>
@endsection
