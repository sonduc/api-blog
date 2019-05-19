<?php

use Illuminate\Http\Request;

// $router->group([
//     'middleware' => 'admin',
// ], function ($router) {
	// Category
	$router->put('/categories/prop-update/{id}', 'CategoryController@minorCategoryUpdate');
	resource('/categories', 'CategoryController', $router);

	// Tag
	$router->put('/tags/prop-update/{id}', 'TagController@minorTagUpdate');
	resource('/tags', 'TagController', $router);

	// User
	resource('/users', 'UserController', $router);
// });

// $router->post('login', 'LoginController@login');