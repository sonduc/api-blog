<?php

namespace App\Repositories\Categories;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Entity
{
	use SoftDeletes;

    protected $table = "categories";
    
    protected $fillable = [
        'name', 'status',
    ];
}
