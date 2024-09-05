@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-12">
    <div class="card">
        <div class="card-header !p-6 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Projects</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#newProjectModal">
                New Project
            </button>
        </div>
        <div class="card-body">
            <div class="mb-3 row !-mt-4 bg-gray-2 p-4 !-mx-4 gap-y-2">
                <form id="projectFilterForm" class="row gap-y-2 items-center">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="projectNameFilter" name="projectName" placeholder="Filter by project name...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="projectStatusFilter" name="projectStatus">
                            <option value="">All Statuses</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn !bg-orange-5 text-white btn-md w-full" id="filterProject">Filter</button>
                    </div>
                </form>

                <script>
                    var projectNameFilter = "{{ request()->projectName ?? '' }}";
                    var projectStatusFilter = "{{ request()->projectStatus ?? '' }}";

                    $('#projectNameFilter').val(projectNameFilter);
                    $('#projectStatusFilter').val(projectStatusFilter);
                </script>


            </div>
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
                        <tr id="project-row-{{ $project->id }}">
                            <th class="align-middle">{{ $index + 1 }}</th>
                            <td class="align-middle">
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="text-orange-5 !underline ">{{ $project->name }}</a>
                            </td>
                            <td class="align-middle">{{ $project->description }}</td>
                            <td class="align-middle">{{ $project->status }}</td>
                            <td class="align-middle row gap-2">
                                <button class="col-md-6 btn btn-sm !bg-orange-5 text-white edit-project" data-project-id="{{ $project->id }}" data-bs-toggle="modal" data-bs-target="#editProjectModal">Edit</button>
                                <button class="col-md-6 btn btn-sm !bg-red-5 text-white delete-project" data-project-id="{{ $project->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            @if($projects->isEmpty())
                <div class="text-center">
                    <p class="text-gray-5">No projects found</p>
                </div>
            @endif

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
                        <textarea class="form-control" id="projectDescription" name="description" rows="3"
                            required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitNewProject">Create Project</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editProjectId" name="id">
                    <div class="mb-3">
                        <label for="editProjectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="editProjectName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProjectDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editProjectDescription" name="description" rows="3"
                            required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitEditProject">Update Project</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        const pageTableRefresh = () => {
            $.get(location.href, function(data) {
                const $htmlTable = $(data).find('table');
                $('table').replaceWith($htmlTable);
            });
        }

        $(document).on('click', '#submitNewProject', function () {
            var formData = $('#newProjectForm').serialize();
            $.ajax({
                url: '{{ route("projects.store") }}',
                type: 'POST',
                data: formData,
            }).always((data) => {
                window.apiInterceptor({ responseJSON: data });
                pageTableRefresh();
                $('#newProjectModal').modal('hide');
            })
        });

        $(document).on('click', '.delete-project', function () {
            var projectId = $(this).data('project-id');
            if (confirm('Are you sure you want to delete this project?')) {
                $.ajax({
                    url: '/api/projects/' + projectId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#project-row-' + projectId).remove();
                        window.apiInterceptor({ responseJSON: response });
                        pageTableRefresh();
                    },
                    error: function (xhr) {
                        window.apiInterceptor(xhr);
                    }
                });
            }
        });

        $(document).on('click', '.edit-project', function () {
            var projectId = $(this).data('project-id');
            var projectName = $(this).closest('tr').find('td:eq(0)').text();
            var projectDescription = $(this).closest('tr').find('td:eq(1)').text();

            $('#editProjectId').val(projectId);
            $('#editProjectName').val(projectName.trim());
            $('#editProjectDescription').val(projectDescription.trim());
        });

        $(document).on('click', '#submitEditProject', function () {
            var formData = $('#editProjectForm').serialize();
            var projectId = $('#editProjectId').val();
            $.ajax({
                url: '/api/projects/' + projectId,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    $('#editProjectModal').modal('hide');
                    window.apiInterceptor({ responseJSON: response });
                    pageTableRefresh();
                },
                error: function (xhr) {
                    window.apiInterceptor(xhr);
                }
            });
        });
    });
</script>
@endsection
