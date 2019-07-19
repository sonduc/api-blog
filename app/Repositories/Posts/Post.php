<?php

namespace App\Repositories\Posts;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Entity
{
	use SoftDeletes;
	// Định nghĩa trạng thái post
	const AVAILABLE    = 1;
    const UNAVAILABLE  = 0;
    const POST_STATUS    = [
        self::AVAILABLE      => 'KHẢ DỤNG',
        self::UNAVAILABLE    => 'KHÔNG KHẢ DỤNG',
    ];

    // Định nghĩa nổi bật post
    const IMPORTANT     = 1;
    const NOT_IMPORTANT = 0;
    const POST_HOT    = [
        self::IMPORTANT      => 'NỔI BẬT',
        self::NOT_IMPORTANT  => 'KHÔNG NỔI BẬT',
    ];

    protected $table = "posts";
    
    protected $fillable = [
        'description', 'content', 'view_count', 'status', 'hot', 'user_id', 'tag_id'
    ];
}
