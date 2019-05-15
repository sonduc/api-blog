<?php 

namespace App\Repositories\Tags;

use App\Repositories\BaseRepository;
use App\Repositories\Tags\Tag;

class TagRepository extends BaseRepository implements TagRepositoryInterface
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
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    public function minorTagUpdate($id, $data = [])
    {
        return parent::update($id, $data);
    }
}