<?php 

namespace App\Repositories\Comments;

use App\Repositories\BaseRepository;
use App\Repositories\Comments\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
	/**
     * Role model.
     * @var Model
     */
    protected $model;

    /**
     * CommentRepository constructor.
     *
     */
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}