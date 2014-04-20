<?php
require_once dirname(__FILE__).'/../CommonDatabase.php';

class UserTest extends CommonDatabase
{
    protected function setUp()
    {
        $conn = $this->getConnection();
        $conn->getConnection()->query("set foreign_key_checks=0");
        parent::setUp();
        $conn->getConnection()->query("set foreign_key_checks=1");
    }

    public function test_check_init()
    {
        $this->assertEquals(1, $this->getConnection()->getRowCount('users'));
    }
}