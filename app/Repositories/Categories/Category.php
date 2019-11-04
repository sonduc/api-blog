<?php

namespace App\Repositories\Categories;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Entity
{
	use FilterTrait, SoftDeletes;
	// Định nghĩa trạng thái category
	const AVAILABLE    = 1;
    const UNAVAILABLE  = 0;
    const CATEGORY_STATUS    = [
        self::AVAILABLE      => 'NỔI BẬT',
        self::UNAVAILABLE    => 'KHÔNG NỔI BẬT',
    ];

    protected $table = "categories";
    
    protected $fillable = [
        'name', 'status',
    ];
}
