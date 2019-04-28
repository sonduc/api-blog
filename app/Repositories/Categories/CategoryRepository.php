<?php 

namespace App\Repositories\Categories;

use App\Repositories\BaseRepository;
use App\Repositories\Categories\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
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
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function minorCategoryUpdate($id, $data = [])
    {
        return parent::update($id, $data);
    }
}