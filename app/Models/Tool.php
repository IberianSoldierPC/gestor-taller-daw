<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Tool extends Model
{
    public const STATUSES = [
        'Disponible',
        'En uso',
        'Mantenimiento',
    ];

    protected $fillable = [
        'name', 'description', 'location', 'status', 'acquisition_date', 'user_id'
    ];

    protected $casts = [
        'acquisition_date' => 'date',
    ];

    public static function statusOptions(): array
    {
        return self::STATUSES;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
