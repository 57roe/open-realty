<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/testSetup.php';
// Include the login class we need to test
require_once dirname(__FILE__).'/../../include/login.inc.php';

/**
 * Unit Test for the Login Class in src/include/login.inc.php
 */
class LoginTest extends testSetup
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        parent::_before();
    }

    protected function _after()
    {
        parent::_after();
    }

    /**
     * Tests that the clear_rememberme_cookie will function without a cookie already existing, and will set an empty cookie.
     *
     * @return void
     */
    public function testClearRememberMeCookieWithNoCookie()
    {
        global $misc;
        $misc->expects()->setcookie('user_id', '', \Mockery::type('int'), '/', 'web.local', false, true);
        $misc->expects()->setcookie('cookie_validator', '', \Mockery::type('int'), '/', 'web.local', false, true);
        $misc->expects()->setcookie('cookie_selector', '', \Mockery::type('int'), '/', 'web.local', false, true);
        
        $login = new Login();
        $login->clear_rememberme_cookie();
    }
    
    /**
     * Tests that clear_rememberme_cookie clears the cookie's selector from the auth_tokens table and sets and empty cookie
     *
     * @return void
     */
    public function testClearRememberMe()
    {
        global $misc, $conn;
        $misc->allows()->make_db_safe('bah')->andReturns('"bah"');
        $misc->allows()->make_db_safe(1)->andReturns(1);
        //Make sure we delete the cookie from the auth_tokens db table.
        $conn->expects()->Execute(
            'DELETE FROM default_auth_tokens
            WHERE userdb_id = 1 AND  selector = "bah"'
        )->andReturns(true);
        //Make sure we clear cookies
        $misc->expects()->setcookie('user_id', '', \Mockery::type('int'), '/', 'web.local', false, true);
        $misc->expects()->setcookie('cookie_validator', '', \Mockery::type('int'), '/', 'web.local', false, true);
        $misc->expects()->setcookie('cookie_selector', '', \Mockery::type('int'), '/', 'web.local', false, true);
        
        $_COOKIE['cookie_selector'] = 'bah';
        $_COOKIE['user_id'] = 1;
        $login = new Login();
        $login->clear_rememberme_cookie();
    }
}
