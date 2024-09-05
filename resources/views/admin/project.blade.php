@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-12">
    <div class="bg-white shadow-md rounded-md p-4 sm:p-6 mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold mb-3 sm:mb-4">{{ $project->name }}</h2>
        <p class="text-gray-600 mb-3 sm:mb-4">{{ $project->description }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div class="bg-blue-100 p-3 sm:p-4 rounded-lg">
                <p class="text-blue-800 font-semibold text-sm sm:text-base">Status</p>
                <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $project->status }}</p>
            </div>
            <div class="bg-green-100 p-3 sm:p-4 rounded-lg">
                <p class="text-green-800 font-semibold text-sm sm:text-base">Total Tasks</p>
                <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $project->tasks->count() }}</p>
            </div>
            <div class="bg-yellow-100 p-3 sm:p-4 rounded-lg">
                <p class="text-yellow-800 font-semibold text-sm sm:text-base">Completed Tasks</p>
                <p class="text-2xl sm:text-3xl font-bold text-yellow-600">
                    {{ $project->tasks->where('status', 'done')->count() }}
                </p>
            </div>
        </div>
        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div class="text-gray-600 mb-3 sm:mb-0 bg-gray-2 fw-bold py-2 px-12 rounded">
                Not Completed Tasks:
                    {{ $project->tasks->whereIn('status', ['todo', 'in-progress'])->count() }}
            </div>
            <div class="space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                <a href="{{ route('admin.projects') }}" class="btn btn-secondary w-full sm:w-auto mb-2 sm:mb-0">Back to Projects</a>
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <div class="card-header !p-6 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tasks</h5>
            <button type="button" class="btn !bg-orange-5 text-white btn-sm" data-bs-toggle="modal"
                data-bs-target="#newTaskModal">New Task</button>
        </div>
        <script>
            var taskDetails = {}
        </script>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Task Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tasks->count() > 0)
                    @foreach($tasks as $index => $task)
                        <tr class="items-center" data-task-id="{{ $task->id }}">
                            <th scope="" class="">{{ $index + 1 }}</th>
                            <td class="align-middle">{{ $task->name }}</td>
                            <td class="align-middle">
                                <select class="form-select status-select" style="max-width: 150px;"
                                    data-task-id="{{ $task->id }}">
                                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                                    <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </td>
                            <td class="align-middle">{{ $task->updated_at->format('d-m-Y H:i') }}</td>
                            <td class="align-middle">
                                <script>
                                    taskDetails[{{ $task->id }}] = {
                                        description: '{{ $task->description }}',
                                    };
                                </script>

                                <button type="button" class="btn !bg-orange-5 text-white btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editTaskModal">
                                    Detail & Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center">No tasks found</td>
                    </tr>
                    @endif
                    <!-- Add more rows for additional tasks -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- New Task Modal -->
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTaskModalLabel">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newTaskForm">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="mb-3">
                        <label for="taskName" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="taskName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">Status</label>
                        <select class="form-select" id="taskStatus" name="status" required>
                            <option value="todo">To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitNewTask">Create Task</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    @csrf
                    <input type="hidden" id="editTaskId" name="id">
                    <div class="mb-3">
                        <label for="editTaskName" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="editTaskName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editTaskDescription" name="description" rows="3"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editTaskStatus" class="form-label">Status</label>
                        <select class="form-select" id="editTaskStatus" name="status" required>
                            <option value="todo">To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitEditTask">Save changes</button>
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


        $(document).on('click', '#submitNewTask', function () {
            var formData = $('#newTaskForm').serialize();
            $.ajax({
                url: '{{ route("tasks.store") }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#newTaskModal').modal('hide');
                    window.apiInterceptor({ responseJSON: response });
                    // Refresh the page to show the new task
                    pageTableRefresh();
                },
                error: function (xhr) {
                    window.apiInterceptor(xhr);
                }
            });
        });

        $(document).on('click', '.delete-task', function () {
            var taskId = $(this).data('task-id');
            if (confirm('Are you sure you want to delete this task?')) {
                $.ajax({
                    url: '/api/tasks/' + taskId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#task-row-' + taskId).remove();
                        window.apiInterceptor({ responseJSON: response });
                        pageTableRefresh();
                    },
                    error: function (xhr) {
                        window.apiInterceptor(xhr);
                    }
                });
            }
        });

        $(document).on('click', '.edit-task', function () {
            var taskId = $(this).data('task-id');
            var taskName = $(this).closest('tr').find('td:eq(0)').text();
            var taskDescription = taskDetails[taskId].description;
            var taskStatus = $(this).closest('tr').find('td:eq(2)').text();

            $('#editTaskId').val(taskId);
            $('#editTaskName').val(taskName);
            $('#editTaskDescription').val(taskDescription);
            $('#editTaskStatus').val(taskStatus);
        });

        // Edit Task Modal when button is clicked
        $(document).on('click', '[data-bs-target="#editTaskModal"]', function () {
            var taskId = $(this).closest('tr').find('.status-select').data('task-id');
            var taskName = $(this).closest('tr').find('td:eq(0)').text();
            var taskStatus = $(this).closest('tr').find('.status-select').val();

            $('#editTaskId').val(taskId);
            $('#editTaskName').val(taskName);
            $('#editTaskStatus').val(taskStatus);
            $('#editTaskDescription').val(taskDetails[taskId].description);

        });

        // Edit Task Modal when form save
        $(document).on('click', '#submitEditTask', function () {
            var formData = $('#editTaskForm').serialize();
            var taskId = $('#editTaskId').val();
            $.ajax({
                url: '/api/tasks/' + taskId,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    $('#editTaskModal').modal('hide');
                    window.apiInterceptor({ responseJSON: response });
                    pageTableRefresh();
                },
                error: function (xhr) {
                    window.apiInterceptor(xhr);
                }
            });
        });

        $(document).on('change', '.status-select', function () {
            var taskId = $(this).data('task-id');
            var status = $(this).val();
            $.ajax({
                url: '/api/tasks/' + taskId,
                type: 'PUT',
                data: { status: status, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    window.apiInterceptor({ responseJSON: response });
                },
                error: function (xhr) {
                    window.apiInterceptor(xhr);
                }
            });
        });

    });
</script>



@endsection
