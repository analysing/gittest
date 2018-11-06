<?php
namespace controllers;

use models\Db;
/**
* 默认控制器
*/
class Index extends Base
{
    public function index()
    {
        // echo $this->version;
        if (!empty($_POST)) {
            $info = $_FILES['file'];
            if ($info['size'] > 2*1024*1024) {
                exit('上传文件大小不能超过2M');
            }
            if (!in_array($info['type'], ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])) {
                exit('文件必须为excel格式');
            }
            $ext = explode('.', $info['name']);
            $ext = end($ext);
            $arr = $this->excel2arr($info['tmp_name'], $ext);
            $count = count($arr);
            $db = new Db();
            $username_arr = $db->queryCol('select username from tbl_user'); // 取得所有用户名
            $tmp_file = str_replace('\\', '/', CTRL_PATH .'user_info.txt');
            $fp = fopen($tmp_file, 'w+'); // 生成并打开临时文件
            $index = count($arr[0]);
            $now = time();
            $unique_arr = [];
            for ($i=1; $i < $count; $i++) {
                // 处理数组中的用户名重复
                while (in_array($arr[$i][0], $unique_arr)) {
                    $arr[$i][0] .= $i;
                }
                array_push($unique_arr, $arr[$i][0]);
                // 处理已存在数据与新增数据重复
                if (in_array($arr[$i][0], $username_arr)) {
                    $arr[$i][0] .= $now . $i;
                }
                // 处理性别
                switch ($arr[$i][6]) {
                    case '男':
                        $arr[$i][6] = 1;
                        break;
                    case '女':
                        $arr[$i][6] = 2;
                        break;
                    default:
                        $arr[$i][6] = 0;
                        break;
                }
                $arr[$i][$index] = $now; // 插入时间
                fwrite($fp, implode("\t", $arr[$i]) ."\n"); // 写入临时文件，\t分割字段，\n分割记录
            }
            fclose($fp);
            // 加上ignore关键字有重复的跳过
            $num = $db->execSql("set character_set_database = utf8;load data infile '$tmp_file' ignore into table tbl_user(`username`,`name`,`password`,`qq`,`phone`,`email`,`gender`,`created`)");
            @unlink($tmp_file); // 删除临时文件
            echo '插入成功了';
            return;
        }
        $this->display('Index/index'); // 渲染视图
    }
}