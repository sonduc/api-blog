<?php

use Illuminate\Http\Request;

// $router->group([
//     'middleware' => 'admin',
// ], function ($router) {
	// Category
	$router->get('/categories/status-list', 'CategoryController@statusList');
	$router->put('/categories/prop-update/{id}', 'CategoryController@minorCategoryUpdate');
	resource('/categories', 'CategoryController', $router);

	// Post
	$router->get('/posts/status-list', 'PostController@statusList');
	$router->get('/posts/hot-list', 'PostController@hotList');
	$router->put('/posts/prop-update/{id}', 'PostController@minorPostUpdate');
	resource('posts', 'PostController', $router);

	// Question
	resource('questions', 'QuestionController', $router);

	// Comment
	resource('comments', 'CommentController', $router);

	// Reply
	resource('relies', 'ReplyController', $router);

	// Tag
	$router->put('/tags/prop-update/{id}', 'TagController@minorTagUpdate');
	resource('/tags', 'TagController', $router);

	// User
	resource('/users', 'UserController', $router);
// });

$router->post('login', 'LoginController@login');