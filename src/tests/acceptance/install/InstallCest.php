<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../testSetup.php';

/**
 * Acceptance test for the install page
 */
class InstallCest extends testSetup
{
    public function _before(AcceptanceTester $I)
    {
        parent::_before($I);
    }
    
    public function _after(AcceptanceTester $I)
    {
        parent::_after($I);
    }

   /**
    * Check that install page loads, and includes our text.
    *
    * @param AcceptanceTester $I
    * @return void
    */
    public function installPageLoads(AcceptanceTester $I)
    {
        $I->amOnPage('/install/');
        $I->see('Before you may install Open-Realty');
    }
}
