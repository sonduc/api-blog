<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Repositories\Questions\Question;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Question $question = null)
    {
        if (is_null($question)) {
            return [];
        }

        return [
            'id'             => $question->id,
            'question'       => $question->question,
            'user_id'        => $question->user_id,
            'tag_id'         => $question->tag_id,
            'created_at'     => $question->created_at,
            'updated_at'     => $question->updated_at,
        ];
    }
}
