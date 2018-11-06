<?php
namespace controllers;

/**
* 基础控制器
*/
class Base
{
    public $version = 'v1.1';

    /**
     * 渲染视图方法
     * @param  string 文件名
     * @param  array 参数
     * @return [type]
     */
    public function display($file, $params = [])
    {
        extract($params);
        $filename = VIEW_PATH . $file .'.html';
        if (!is_file($filename) || !$file) {
            include VIEW_PATH .'err.html';exit();
        }
        ob_start();
        ob_implicit_flush(0);
        include $filename;
        $content = ob_get_clean();

        // 网页字符编码
        header('Content-Type:text/html; charset=utf-8');
        echo $content;
    }

    /**
     * excel转数组
     * @param  string 文件名
     * @param  string 文件后缀
     * @return array 
     */
    public function excel2arr($file, $ext = '')
    {
        require_once VENDOR_PATH .'PHPExcel/PHPExcel.php';
        /*switch ($ext) {
            case 'xlsx':
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
                break;
            default:
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
                break;
        }
        $objPHPExcel = $objReader->load($file);*/
        $objPHPExcel = \PHPExcel_IOFactory::load($file);
        $arr = $objPHPExcel->getActiveSheet()->toArray();
        return $arr;
    }
}