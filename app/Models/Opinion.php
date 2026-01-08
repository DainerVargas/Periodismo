<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $fillable = ['title', 'slug', 'author', 'image', 'content'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
