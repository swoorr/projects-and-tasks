<?php

namespace App\Services;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TasksServices
{
    /**
     * Get all tasks.
     *
     * @return Collection
     */
    public function getAllTasks(): Collection
    {
        return Tasks::all();
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Tasks
     * @throws ValidationException
     */
    public function createTask(array $data): Tasks
    {
        $validator = Validator::make($data, [
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'status' => 'string|in:todo,in-progress,done',
            'project_id' => 'exists:projects,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Tasks::create($validator->validated());
    }

    /**
     * Get a specific task by ID.
     *
     * @param int $id
     * @return Tasks|null
     */
    public function getTaskById(int $id): ?Tasks
    {
        return Tasks::find($id);
    }

    /**
     * Update a task.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function updateTask(int $id, array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:todo,in-progress,done',
            'project_id' => 'exists:projects,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $task = $this->getTaskById($id);
        if (!$task) {
            return false;
        }
        return $task->update($validator->validated());
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return bool
     */
    public function deleteTask(int $id): bool
    {
        $task = $this->getTaskById($id);
        if (!$task) {
            return false;
        }
        return $task->delete();
    }
}
