<?php
/**
* test
*/
class P
{
    
    function __construct()
    {
        echo 'chushihuachenggong.';
    }

    public function say()
    {
        echo 'hello';
    }
}

$p = new P();
$p->say();

echo 'there are  ', $argc ,' parameters';
print_r($argv);