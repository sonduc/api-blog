<?php 

namespace App\Repositories\Users;

use App\Repositories\BaseRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
	/**
     * Role model.
     * @var Model
     */
    protected $model;

    /**
     * CategoryRepository constructor.
     *
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function storeUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        return parent::store($data);
    }

    /**
     * Lưu thông tin 1 bản ghi mới
     *
     * @param array $data
     *
     * @return \App\Repositories\Eloquent
     */
    public function store($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user  = parent::store($data);
        $roles = array_get($data, 'roles', []);

        if (count($roles)) {
            $user->roles()->attach($roles);
        }

        return $user;
    }

    public function update($id, $data, $except = [], $only = [])
    {
        $user = parent::update($id, $data);
        $roles = array_get($data, 'roles', []);
        $user->roles()->detach();
        $user->roles()->attach($roles);
        return $user;
    }
}