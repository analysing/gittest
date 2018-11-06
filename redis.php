<?php
$redis = new Redis();
$redis->connect('192.168.100.14', 6379);
$redis->auth('123456');

echo $redis->ping() ,' ', $redis->get('name');