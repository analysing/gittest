<?php
namespace controllers;

/**
* 测试控制器
*/
class Test extends Base
{
    public function index()
    {
        echo 'testing...';
        $this->display('Test/index', ['a' => 'apple', 'b' => 'boy']);
    }

    protected function test()
    {
        echo 'testing again...';
    }

    public function say($msg = 'hello world')
    {
        $msg = filter_input(INPUT_GET, 'msg');
        echo $msg;
    }
}