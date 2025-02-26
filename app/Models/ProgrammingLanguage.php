<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammingLanguage extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function users() {
        return $this->belongsToMany(User::class, 'user_programming_language');
    }
    public function projects() {
        return $this->belongsToMany(Project::class, 'project_programming_language');
    }
}
