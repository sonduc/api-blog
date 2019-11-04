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

    public function storeRole($data)
    {
        $data['permissions'] = json_encode($data['permissions']);
        return $this->model->create($data);
    }
    public function updateRole($id,$data)
    {
        $data['permissions'] = json_encode($data['permissions']);
        $this->model->find($id)->update($data); 
        return $this->model->find($id);       
    }

}