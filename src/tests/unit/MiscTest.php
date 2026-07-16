<?php
// Include our base testSetup class.
require_once dirname(__FILE__) . '/testSetup.php';
// Include the Misc class we need to test
require_once(dirname(__FILE__).'/../../include/misc.inc.php');

/**
 * Unit Test for the Misc Class in src/include/misc.inc.php
 */
class MiscTest extends testSetup
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
     * Test that generate_csrf_token places a csrf_token in our $_SESSION
     *
     * @return void
     */
    public function test_generate_csrf_token(): void
    {
        $misc = new Misc();
        
        $this->assertArrayNotHasKey('csrf_token', $_SESSION);
        $misc->generate_csrf_token();
        $this->assertArrayHasKey('csrf_token', $_SESSION);
    }
    
    /**
     * That that generate_csrf_token does not generate a csrf_token if one already exists in the session.
     *
     * @return void
     */
    public function test_generate_csrf_token_is_idimpotent(): void
    {
        $misc = new Misc();
        $this->assertArrayNotHasKey('csrf_token', $_SESSION);
        $misc->generate_csrf_token();
        $this->assertArrayHasKey('csrf_token', $_SESSION);
        $token1 = $_SESSION['csrf_token'];
        $misc->generate_csrf_token();
        $this->assertEquals($token1, $_SESSION['csrf_token']);
    }

    /**
     * That that validate_csrf_token returns false if no token exist in our session.
     *
     * @return void
     */
    public function test_validate_csrf_token_notoken(): void
    {
        $misc = new Misc();
        $valid = $misc->validate_csrf_token("Bad Match");
        $this->assertFalse($valid);
    }
    /**
     * That that validate_csrf_token returns false if it is the incorrect token.
     *
     * @return void
     */
    public function test_validate_csrf_token_invalid(): void
    {
        $misc = new Misc();
        $misc->generate_csrf_token();
        $valid = $misc->validate_csrf_token("Bad Match");
        $this->assertFalse($valid);
    }
   
    /**
     * That that validate_csrf_token returns true if the token passes is correct.
     *
     * @return void
     */
    public function test_validate_csrf_token_valid(): void
    {
        $misc = new Misc();
        $misc->generate_csrf_token();
        $valid = $misc->validate_csrf_token($_SESSION['csrf_token']);
        $this->assertTrue($valid);
    }
    
    /**
     * Test that validate_csrf_token clears the existing token from the session on successful validation.
     *
     * @return void
     */
    public function test_validate_csrf_token_isunset(): void
    {
        $misc = new Misc();
        $misc->generate_csrf_token();
        $valid = $misc->validate_csrf_token($_SESSION['csrf_token']);
        $this->assertArrayNotHasKey('csrf_token', $_SESSION);
    }
    
    /**
     * Check if we parse a Chrome on Android User Header and detect it is a mobile browser.
     */
    public function testDetectMobileBrowserAndroidChrome(): void
    {
        $misc = new Misc();
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Linux; Android 13) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.5195.136 Mobile Safari/537.36';
        $isMobile = $misc->detect_mobile_browser();
        $this->assertTrue($isMobile);
    }
    
    /**
     * Check if we parse a Firefox on Android User Header and detect it is a mobile browser.
     */
    public function testDetectMobileBrowserAndroidFirefox(): void
    {
        $misc = new Misc();
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Android 13; Mobile; rv:68.0) Gecko/68.0 Firefox/105.0';
        $isMobile = $misc->detect_mobile_browser();
        $this->assertTrue($isMobile);
    }
    
    /**
     * Check if we parse WebKit on Apple iPhone 11 and detect it is a mobile browser.
     */
    public function testDetectMobileBrowserIphoneWebkit(): void
    {
        $misc = new Misc();
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Instagram 244.0.0.12.112 (iPhone12,1; iOS 15_5; en_US; en-US; scale=2.00; 828x1792; 383361019)';
        $isMobile = $misc->detect_mobile_browser();
        $this->assertTrue($isMobile);
    }
    
    /**
     * Check if we parse Chrome on Windowsand detect it is not  mobile browser.
     */
    public function testDetectMobileBrowserWindowsChrome(): void
    {
        $misc = new Misc();
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36';
        $isMobile = $misc->detect_mobile_browser();
        $this->assertFalse($isMobile);
    }
    
    public function testInternationalNumFormatGermany(): void
    {
        global $config;
        $misc = new Misc();
        $config['number_format_style'] = 2; // spain, germany
        $config['force_decimals'] = 0;
        $value = $misc->international_num_format('1000', 2);
        $this->assertEquals('1.000', $value);
    }
    public function testInternationalNumFormatGermanyHasDecimals(): void
    {
        global $config;
        $misc = new Misc();
        $config['number_format_style'] = 2; // spain, germany
        $config['force_decimals'] = 0;
        $value = $misc->international_num_format('1000.01', 2);
        $this->assertEquals('1.000,01', $value);
    }
    public function testInternationalNumFormatGermanyHasDecimals00(): void
    {
        global $config;
        $misc = new Misc();
        $config['number_format_style'] = 2; // spain, germany
        $config['force_decimals'] = 0;
        $value = $misc->international_num_format('1000.00', 2);
        $this->assertEquals('1.000', $value);
    }
    public function testInternationalNumFormatGermanyHasDecimals00ForceDecimals(): void
    {
        global $config;
        $misc = new Misc();
        $config['number_format_style'] = 2; // spain, germany
        $config['force_decimals'] = 1;
        $value = $misc->international_num_format('1000.00', 2);
        $this->assertEquals('1.000,00', $value);
    }
    public function testInternationalNumFormatGermanyForceDecimals(): void
    {
        global $config;
        $misc = new Misc();
        $config['number_format_style'] = 2; // spain, germany
        $config['force_decimals'] = 1;
        $value = $misc->international_num_format('1000', 2);
        $this->assertEquals('1.000,00', $value);
    }
}
