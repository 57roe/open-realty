<?php

require_once dirname(__FILE__) . '/../../include/misc.inc.php';

abstract class testSetup extends \Codeception\Test\Unit
{
    private function setupConfig(): void
    {
        global $config;
        $config['baseurl'] = 'http://web.local';
        $config['basepath']  = dirname(__FILE__, 3);
        $config['strip_html'] = 0;
        $config['table_prefix_no_lang'] = 'default_';
        $config['table_prefix'] = 'default_en_';
    }
    private function cleanupAll(): void
    {
        global $config, $misc;
        unset($config);
        unset($misc);
        $_COOKIE=array();
    }
    protected function _before()
    {
        global $misc, $conn;
        @session_start();
        session_reset();
        $conn = Mockery::mock();
        $misc = Mockery::mock();
        $this->setupConfig();
        parent::_before();
    }

    protected function _after()
    {
        $this->cleanupAll();
        parent::_after();
    }
    
    /**
     * /Reflector to run private function
     *
     * @param class $object - A Class Object that contains a private function we need to test
     * @param string $methodName - Name of the private function we need to test
     * @param array $parameters - Paramaters to pass to the private function
     * @return void
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
