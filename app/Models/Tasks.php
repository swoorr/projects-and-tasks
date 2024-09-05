<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'description', 'status']; // {{ edit_1 }}

    public function project() // {{ edit_2 }}
    {
        return $this->belongsTo(Projects::class);
    }
}
