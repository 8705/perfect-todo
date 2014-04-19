<?php

require_once dirname(__FILE__).'/../../PerfectApplication_dev.php';

class AccountControllerTest extends PHPUnit_Framework_TestCase
{
    public $app;

    public function setUp()
    {
        $this->app = new PerfectApplication_dev(true);
    }

    public function testIndex()
    {
        $content = $this->app->run('/account/index');
    }
}