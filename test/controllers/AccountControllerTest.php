<?php

require_once dirname(__FILE__).'/../PerfectUnit.php';

class AccountControllerTest extends PerfectUnit
{
    // public $app;

    public function setUp()
    {
        parent::setUp();
        // $this->app = new PerfectApplication_dev(true);
    }

    public function testIndex()
    {
        $content = $this->dispatch('/account/index');
        $this->assertContains('アカウント - Perfect Todo', $content);
        // debug($content);
    }
}