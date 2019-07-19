<?php 

namespace App\Repositories\Posts;

use App\Repositories\BaseRepository;
use App\Repositories\Posts\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
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
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function minorPostUpdate($id, $data = [])
    {
        return parent::update($id, $data);
    }
}