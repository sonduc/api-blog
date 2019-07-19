<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Replies\Reply;

class ReplyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Reply $reply = null)
    {
        if (is_null($reply)) {
            return [];
        }

        return [
            'id'             => $reply->id,
            'reply'          => $reply->reply,
            'user_id'        => $reply->user_id,
            'comment_id'     => $reply->comment_id,
            'created_at'     => $reply->created_at,
            'updated_at'     => $reply->updated_at,
        ];
    }
}
