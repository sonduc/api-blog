<?php

namespace App\Repositories\Comments;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Entity
{
	use SoftDeletes;

    protected $table = "comments";
    
    protected $fillable = [
        'comment', 'post_id', 'question_id', 'user_id',
    ];
}
