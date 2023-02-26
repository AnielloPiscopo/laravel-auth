<?php

/*
|--------------------------------------------------------------------------
| Project Class
|--------------------------------------------------------------------------
|
| A class that represents a project istance
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = array('title' , 'slug' , 'description' , 'img_path');

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isImageAUrl(){
        return filter_var($this->img_path, FILTER_VALIDATE_URL);
    }
}