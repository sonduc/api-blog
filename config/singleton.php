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
     * Tag binding
     */
    \App\Repositories\Tags\Tag::class => [
        \App\Repositories\Tags\TagRepositoryInterface::class,
        \App\Repositories\Tags\TagRepository::class,
    ],
];