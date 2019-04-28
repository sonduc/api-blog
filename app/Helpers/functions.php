<?php 

	/**
	 * resource router helper
	 *
	 * @param  string                       $uri        enpoint url
	 * @param  string                       $controller controller name
	 */
	function resource($uri, $controller, Illuminate\Routing\Router $router)
	{
	    $router->get($uri, $controller . '@index');
	    $router->get($uri . '/{id}', $controller . '@show');
	    $router->post($uri, $controller . '@store');
	    $router->put($uri . '/{id}', $controller . '@update');
	    $router->delete($uri . '/{id}', $controller . '@destroy');
	}

	if (!function_exists('trans2')) {
	    function trans2($id = null, $replace = [])
	    {
	        $locale = getLocale();

	        return trans($id, $replace, $locale);
	    }
	}
	
	if (!function_exists('getLocale')) {
	    function getLocale()
	    {
	        $locale = \Illuminate\Support\Facades\Cookie::get('locale');
	        if (!array_key_exists($locale, config('languages'))) {
	            $locale = config('app.locale');
	        }
	        return $locale;
	    }
	}