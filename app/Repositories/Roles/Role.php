<?php

namespace App\Repositories\Roles;

use App\Repositories\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Entity
{
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
    
    public function hasAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check a specific permission that belongs to this role
     *
     * @param  string $permission
     *
     * @return boolean
     */
    private function hasPermission(string $permission): bool
    {
        return $this->permissions[$permission] ?? false;
    }
}
