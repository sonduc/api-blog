<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Posts\Post;

class PostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post = null)
    {
        if (is_null($post)) {
            return [];
        }

        return [
            'id'             => $post->id,
            'description'    => $post->description,
            'content'        => $post->content,
            'status'         => $post->status,
            'view_count'     => $post->view_count,
            'hot'            => $post->hot,
            'user_id'        => $post->user_id,
            'tag_id'         => $post->tag_id,
            'created_at'     => $post->created_at,
            'updated_at'     => $post->updated_at,
        ];
    }
}
