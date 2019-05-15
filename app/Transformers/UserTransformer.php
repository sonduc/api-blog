<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user = null)
    {
        if (is_null($user)) {
            return [];
        }

        return [
            'id'        => $user->id,
            'name'      => $user->user_name,
            'email'     => $user->email,
            'about'     => $user->about,
        ];
    }
}
