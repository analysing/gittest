<?php

$memcache = memcache_connect('192.168.100.14', 11211);
/*$memcache = new Memcache();
$memcache->connect('192.168.100.14', 11211);*/

if ($memcache) {
	$memcache->set("str_key", "String to store in memcached");
	$memcache->set("num_key", 123);

	$object = new StdClass;
	$object->attribute = 'test';
	$object->attribute2 = 'test2';
	$memcache->set("obj_key", $object);

	$array = Array('assoc'=>123, 345, 567);
	$memcache->set("arr_key", $array);

	echo '<pre>';
	var_dump($memcache->get('str_key'));
	var_dump($memcache->get('num_key'));
	var_dump($memcache->get('obj_key'));
	var_dump($memcache->get('arr_key'));
	echo '</pre>';
}
else {
	echo "Connection to memcached failed";
}
?>

