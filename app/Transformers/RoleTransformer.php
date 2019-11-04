<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Roles\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Role $role = null)
    {
        if (is_null($role)) {
            return [];
        }

        return [
            'id'          => $role->id,
            'name'        => $role->name,
            'slug'        => $role->slug,
            'permissions' => json_decode($role->permissions)
        ];
    }
}
