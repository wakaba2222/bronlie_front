<?php
return array(
	'_root_'  => 'home/index',  // The default route
	'_401_'   => 'home/401',    // The main 401 route
	'_403_'   => 'home/403',    // The main 403 route
	'_404_'   => 'home/404',    // The main 404 route
	'_500_'   => 'home/500',    // The main 500 route
	'_503_'   => 'home/503',    // The main 503 route


	'mall/(:segment)' => 'mall/shoptop',
	'mall/:shop/item' => 'item/index',
	'mall/:shop/justin' => 'justin/index',
	'mall/:shop/brand' => 'brand/index',
	'mall/:shop/feature' => 'feature/index',
	'mall/:shop/editorschoice' => 'editorschoice/index',
	'mall/:shop/stylesnap' => 'stylesnap/index',
	'mall/:shop/blog' => 'blog/index',
	'mall/:shop/item/(:segment)' => 'item/index',
	'mall/:shop/brand' => 'brand/index',
	'user_data/update_stock' => 'updatestock',
	'mall/:shop/theme' => 'theme/index',




//	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);
