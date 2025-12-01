<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Tool extends Model
{
    protected $fillable = [
        'name', 'description', 'location', 'status', 'acquisition_date', 'user_id'
    ];
    protected $casts = [
    'acquisition_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
