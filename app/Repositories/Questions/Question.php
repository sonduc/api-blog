<?php

namespace App\Repositories\Questions;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Entity
{
	use SoftDeletes;

    protected $table = "questions";
    
    protected $fillable = [
        'question', 'user_id', 'tag_id'
    ];
}
