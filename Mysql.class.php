<?php
/**
* MySQL操作类，未完成：1.事务操作；2.连贯操作
*/
class Mysql
{
	protected $dbh;

	public function __construct($conf)
	{
		try {
			// extract($conf);
			// PDO连接
			// $this->dbh = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset;port=$db_port", $db_user, $db_pass);
			if (!isset($conf['db_name']) || !$conf['db_name']) {
				throw new \Exception('pls select database');
			}
			if (!isset($conf['db_user']) || !$conf['db_user'] || !isset($conf['db_pass'])) {
				throw new \Exception('pls set mysql login name and pwd');
			}
			$db_host = '127.0.0.1';
			if (isset($conf['db_host']) && $conf['db_host']) {
				$db_host = $conf['db_host'];
			}
			$db_charset = 'utf8';
			if (isset($conf['db_charset']) && $conf['db_charset']) {
				$db_charset = $conf['db_charset'];
			}
			$db_port = 3306;
			if (isset($conf['db_port']) && $conf['db_port']) {
				$db_port = $conf['db_port'];
			}
			$this->dbh = new \PDO("mysql:host=$db_host;dbname={$conf['db_name']};charset=$db_charset;port=$db_port", $conf['db_user'], $conf['db_pass']);
		} catch (\PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * 获取原生PDO对象
	 * @return object PDO对象
	 */
	public function getPdo()
	{
		return $this->dbh;
	}

	/**
	 * 根据SQL获取一行数据
	 * @param  string $sql SQL语句
	 * @return array      一维数组
	 */
	public function fetch($sql)
	{
		$query = $this->dbh->query($sql);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$res = $query->fetch();
		return $res;
	}

	/**
	 * 根据SQL获取多行数据
	 * @param  string $sql SQL语句
	 * @return array      二维数据
	 */
	public function fetchAll($sql)
	{
		$query = $this->dbh->query($sql);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$res = $query->fetchAll();
		return $res;
	}

	/**
	 * 根据SQL获取第一行第一列数据
	 * @param  string $sql SQL语句
	 * @return mixed      第一行第一列数据
	 */
	public function fetchCol($sql)
	{
		$query = $this->dbh->query($sql);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$res = $query->fetchColumn();
		return $res;
	}

	/**
	 * 执行一条SQL语句，用于insert，update，delete等dml语句
	 * @param  string $sql SQL语句
	 * @return int      受影响行数
	 */
	public function exec($sql)
	{
		try {
			$num = $this->dbh->exec($sql);
		} catch (\PDOException $e) {
			// exit('error: '. $e->getMessage());
			throw new \Exception($e->getMessage());
		}
		return $num;
	}

	/**
	 * 获取最后插入id
	 * @return int 最后插入id
	 */
	public function getLastInsId()
	{
		return $this->dbh->lastInsertId();
	}

	/**
	 * 获取自增id
	 * @param  string $db_name  数据库名称
	 * @param  string $tbl_name 表名
	 * @return int           自增id
	 */
	public function getAutoIncrememntId($db_name, $tbl_name)
	{
		$sql = "select `AUTO_INCREMENT` from information_schema.TABLES where TABLE_SCHEMA = '$db_name' and TABLE_NAME = '$tbl_name'";
		$res = $this->fetchCol($sql);
		return $res;
	}
}