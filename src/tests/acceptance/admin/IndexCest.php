<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../testSetup.php';

/**
 * Acceptance Test for the admin index page.
 */
class AdminIndexCest extends testSetup
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
     * Test that login as admin works and the dashboard loads, by looking for Open-Realty Version widget
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function indexPageLoads(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->see('Open-Realty Version');
    }
}
