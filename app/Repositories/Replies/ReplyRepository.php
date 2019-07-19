<?php 

namespace App\Repositories\Replies;

use App\Repositories\BaseRepository;
use App\Repositories\Replies\Reply;

class ReplyRepository extends BaseRepository implements ReplyRepositoryInterface
{
	/**
     * Role model.
     * @var Model
     */
    protected $model;

    /**
     * ReplyRepository constructor.
     *
     */
    public function __construct(Reply $reply)
    {
        $this->model = $reply;
    }
}