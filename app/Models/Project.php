<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'project_name',
        'project_description',
    ];

    public $primaryKey = 'project_id';
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
