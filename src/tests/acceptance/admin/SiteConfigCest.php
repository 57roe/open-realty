<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../testSetup.php';

/**
 * Acceptance Test For the Site Config Page
 */
class SiteConfigCest extends testSetup
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
     * Test that all of our Site Config Tabs are present
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function allTabsShow(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=configure');
        $I->seeElement('#configure_general_tab');
        $I->seeElement('#configure_templates_tab');
        $I->seeElement('#configure_seo_tab');
        $I->seeElement('#configure_seo_links_tab');
        $I->seeElement('#configure_uploads_tab');
        $I->seeElement('#configure_listings_tab');
        $I->seeElement('#configure_users_tab');
        $I->seeElement('#configure_social_tab');
    }
    
    /**
     * Test that the seo links show the correct default value's including template tags.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function checkSEOLinksPageDefaults(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=configure');
        $I->click('#configure_seo_links_tab');
        $I->waitForJS("return $.active == 0;", 60);
        //$I->waitForElement('#listing_slug', 30); // secs
        $I->seeInField('listing_slug', 'listing/');
        $I->seeInField('listing_uri', '{listing_seotitle}.html');
        $I->seeInField('page_slug', '');
        $I->seeInField('page_uri', '{page_seotitle}.html');
    }
}
