<?php

use Illuminate\Http\Request;

// Category
$router->put('/categories/prop-update/{id}', 'CategoryController@minorCategoryUpdate');
resource('/categories', 'CategoryController', $router);

// Tag
$router->put('/tags/prop-update/{id}', 'TagController@minorCategoryUpdate');
resource('/tags', 'TagController', $router);