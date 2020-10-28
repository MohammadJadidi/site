<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use Sluggable;
    protected $guarded =[];
    protected $casts=[
        'images'=>'array'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function path()
    {
        return "/courses/$this->slug";
    }
}
