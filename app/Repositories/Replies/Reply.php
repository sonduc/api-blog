<?php

namespace App\Repositories\Replies;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Entity
{
	use SoftDeletes;

    protected $table = "replies";
    
    protected $fillable = [
        'reply', 'comment_id', 'user_id'
    ];
}
