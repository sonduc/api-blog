<?php 

namespace App\Repositories\Roles;

use App\Repositories\BaseRepository;
use App\Repositories\Roles\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
	/**
     * Role model.
     * @var Model
     */
    protected $model;

    /**
     * RoleRepository constructor.
     *
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

}