<?php

class CommonDatabase extends PHPUnit_Extensions_Database_TestCase
{
    // PDO のインスタンス生成は、クリーンアップおよびフィクスチャ読み込みのときに一度だけ
    static private $pdo = null;

    // PHPUnit_Extensions_Database_DB_IDatabaseConnection のインスタンス生成は、テストごとに一度だけ
    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }
        // echo 'データべーすだよ＝';
        // var_dump($this->conn);exit;
        return $this->conn;
    }

    /**
      * フィクスチャを読み込んで、データベースを初期化する
      *
      */
    public function getDataSet()
    {
        return $this->createXmlDataSet(dirname(__FILE__).'/fixtures/init.xml');
    }


}