<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = array('title' , 'slug' , 'description');

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}