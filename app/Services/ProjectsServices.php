<?php

namespace App\Services;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProjectsServices
{
    /**
     * Get all projects.
     *
     * @return Collection
     */
    public function getAllProjects(): Collection
    {
        return Projects::all();
    }

    /**
     * Create a new project.
     *
     * @param array $data
     * @return Projects
     * @throws ValidationException
     */
    public function createProject(array $data): Projects
    {
        $validator = Validator::make($data, [
            'name' => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Projects::create($validator->validated());
    }

    /**
     * Get a specific project by ID.
     *
     * @param int $id
     * @return Projects|null
     */
    public function getProjectById(int $id): ?Projects
    {
        return Projects::find($id);
    }

    /**
     * Update a project.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function updateProject(int $id, array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $project = $this->getProjectById($id);
        if (!$project) {
            return false;
        }
        return $project->update($validator->validated());
    }

    /**
     * Delete a project.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProject(int $id): bool
    {
        $project = $this->getProjectById($id);
        if (!$project) {
            return false;
        }
        return $project->delete();
    }
}

