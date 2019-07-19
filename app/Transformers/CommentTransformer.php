<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Comments\Comment;

class CommentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Comment $comment = null)
    {
        if (is_null($comment)) {
            return [];
        }

        return [
            'id'             => $comment->id,
            'comment'        => $comment->comment,
            'post_id'        => $comment->post_id,
            'user_id'        => $comment->user_id,
            'question_id'    => $comment->question_id,
            'created_at'     => $comment->created_at,
            'updated_at'     => $comment->updated_at,
        ];
    }
}
