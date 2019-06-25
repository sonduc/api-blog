<?php

namespace App\Repositories\Categories;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Entity
{
	use SoftDeletes;

    protected $table = "roles";
    
    protected $fillable = [
        'name', 'slug', 'permissions',
    ];

    /**
     * Relationship with user
     * @return Relation
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'role_users');
    }
}
