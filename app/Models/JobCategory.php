<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    public function vacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }
}
