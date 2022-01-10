<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes, HasFactory;
    protected $table = "projects";
    protected $guarded = [];

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function developerTasks($id)
    {
        return $this->hasMany(Task::class)->where('assign_to',$id)->get();
    }
}
