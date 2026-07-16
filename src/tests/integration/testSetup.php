<?php

define('INT_USER', 'admin');
define('INT_PASS', 'password');
require_once dirname(__FILE__) . '/../../install/base_installer.php';

abstract class testSetup extends \Codeception\Test\Unit
{
    private function setupGetVars(): void
    {
        $_GET['step'] = "autoinstall";
        $_GET['or_install_lang'] = "en";
        $_GET['or_install_type'] = "install_300";
        $_GET['table_prefix'] = "default_";
        $_GET['db_type'] = "mysqli";
        $_GET['db_server'] = "db";
        $_GET['db_user'] = "openrealty";
        $_GET['db_password'] = "orpassword";
        $_GET['db_database'] = "openrealty";
        $_GET['basepath'] = dirname(__FILE__, 3);
        $_GET['baseurl'] = "http://web.local";
        $_GET['default_email'] = "rb2297+integration-tests@gmail.com";
    }
    private function cleanupAll(): void
    {
        $_SESSION=array();
        @session_destroy();
        $_GET=array();
        $this->tester->deleteDir(dirname(__FILE__, 3).'/images/listing_photos');
        $this->tester->deleteDir(dirname(__FILE__, 3).'/images/blog_uploads');
        $this->tester->deleteDir(dirname(__FILE__, 3).'/images/page_uploads');
        $this->tester->deleteDir(dirname(__FILE__, 3).'/images/user_photos');
        $this->tester->deleteDir(dirname(__FILE__, 3).'/images/vtour_photos');
        $this->tester->copyDir(dirname(__FILE__, 3).'/tests/_assets/images', dirname(__FILE__, 3).'/images');
    }
    protected function _before()
    {
        $this->cleanupAll();
        $this->setupGetVars();
        $installer = new installer();
        $installer->drop_all_tables($_GET['db_type'], $_GET['db_server'], $_GET['db_user'], $_GET['db_password'], $_GET['db_database']);
        $installer->run_installer();

        $this->cleanupAll();
        parent::_before();
    }

    protected function _after()
    {
        parent::_after();
    }
}
