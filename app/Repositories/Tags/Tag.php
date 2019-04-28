<?php

namespace App\Repositories\Tags;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
	use SoftDeletes;

    protected $table = "tags";
    
    protected $fillable = [
        'tag_name', 'hot',
    ];
}