1、建立一个用户库
2、做个用户EXCEL导入；
3、多次导入，如遇到库中已存在的用户名，重新命名，随机加个后缀，在插入数据库
4、要求：用户数据不重复
5、注意：同一次也可能会有重复，一次导入数据会有10万左右，要求都不允许重复
6、不要用框架，代码要规范

单入口
mvc
视图渲染
路由
类自动加载
读取配置文件
excel》array
数据库操作

#1290 - The MySQL server is running with the --secure-file-priv option so it cannot execute this statement
设置my.cnf文件[mysqld] secure_file_priv=
secure_file_priv=null 不允许所有导入操作（默认）
secure_file_priv=/tmp/ 只允许/tmp/目录下文件导入
secure_file_priv= 允许所有导入操作
