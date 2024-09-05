<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * status calculation
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->tasks()->where('status', 'in-progress')
        ->orWhere('status', 'todo')
        ->count() > 0 ? 'in-progress' : 'done';
    }


    /**
     * tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'project_id', 'id');
    }
}
