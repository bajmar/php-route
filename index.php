<?php

include 'route.php';

$route = new Route();

$route->add('/', function() {
	echo 'Home page';
});

$route->add('/contact', function() {
	echo 'Contact page';
});

$route->add('/portfolio/.+', function($name) {
	echo "Portfolio $name";
});

$route->add('/category/page/.+/tag/.+', function($a, $b) {
	echo "Page $a tag $b";
});

$route->run();
