<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Categories\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category = null)
    {
        if (is_null($category)) {
            return [];
        }

        return [
            'id'           => $category->id,
            'name'         => $category->name,
            'status'       => $category->status,
            'updated_at'   => $category->updated_at,
        ];
    }
}
