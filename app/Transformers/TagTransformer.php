<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Tags\Tag;

class TagTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tag $tag = null)
    {
        if (is_null($tag)) {
            return [];
        }

        return [
            'id'            => $tag->id,
            'tag_name'      => $tag->tag_name,
            'hot'           => $tag->hot,
            'updated_at'    => $tag->updated_at,
        ];
    }
}
