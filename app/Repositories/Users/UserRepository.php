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
}