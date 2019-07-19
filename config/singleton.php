<?php

return [
	/**
     * Category binding
     */
    \App\Repositories\Categories\Category::class => [
        \App\Repositories\Categories\CategoryRepositoryInterface::class,
        \App\Repositories\Categories\CategoryRepository::class,
    ],

    /**
     * Post binding
     */
    \App\Repositories\Posts\Post::class => [
        \App\Repositories\Posts\PostRepositoryInterface::class,
        \App\Repositories\Posts\PostRepository::class,
    ],

    /**
     * Question binding
     */
    \App\Repositories\Questions\Question::class => [
        \App\Repositories\Questions\QuestionRepositoryInterface::class,
        \App\Repositories\Questions\QuestionRepository::class,
    ],
    
	/**
     * Tag binding
     */
    \App\Repositories\Tags\Tag::class => [
        \App\Repositories\Tags\TagRepositoryInterface::class,
        \App\Repositories\Tags\TagRepository::class,
    ],
    
    /**
     * Uer binding
     */
    \App\User::class  => [
        \App\Repositories\Users\UserRepositoryInterface::class,
        \App\Repositories\Users\UserRepository::class,
    ],
];