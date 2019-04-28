<?php

namespace App\Repositories\Categories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

    protected $table = "categories";
    
    protected $fillable = [
        'name', 'status',
    ];
}
