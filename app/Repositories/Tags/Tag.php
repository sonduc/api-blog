<?php

namespace App\Repositories\Tags;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Entity
{
	use SoftDeletes;

    protected $table = "tags";
    
    protected $fillable = [
        'tag_name', 'hot',
    ];
}
