<?php
$redis = new Redis();
$redis->connect('192.168.20.107', 6379);
$redis->auth('ivy1234');
$redis->select(1);
var_dump($redis->get('nameaaa'));
var_dump($redis->set('name', 'ivyivy'));
echo $redis->ping() ,' ', $redis->get('name');
