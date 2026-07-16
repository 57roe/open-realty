<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../testSetup.php';

/**
 * Acceptance Test for the Listing Editor's Media Widget
 */
class ListingEditorMediaWidgetCest extends testSetup
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
     * Test that for listing 1 all 5 default images load when open the edit listing page.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function imagesLoadDefault(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_listing&edit=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#image_1', 30); // secs
        $I->seeElement('#image_1');
        $I->seeElement('#image_2');
        $I->seeElement('#image_3');
        $I->seeElement('#image_4');
        $I->seeElement('#image_5');
    }
    
    /**
     * Test that the media widget is loading the thumbnail image, not the full size image.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function loadImageThumbs(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_listing&edit=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#image_1', 30); // secs
        $I->seeElement('#image_1 img[src$="thumb_1_white-house.jpg"]');
    }
    
    /**
     * Test that when the edit listing page loads, only the image pane is open by default
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function defaultOnlyImagePaneVisible(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_listing&edit=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#listing_image_pane', 30); // secs
        $I->seeElement("#listing_image_pane");
        $I->dontSeeElement("#listing_file_pane");
        $I->dontSeeElement("#listing_vtour_pane");
    }
    
    /**
     * Test that when we click on the File Tab in the media widget it's pane opens and the image pane closes.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function filePaneOpens(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_listing&edit=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#listing_image_pane', 30); // secs
        $I->seeElement("#listing_image_pane");
        $I->click("#listing_file_tab");
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElementNotVisible("#listing_image_pane");
        $I->seeElement("#listing_file_pane");
    }
    
    /**
     * Test that when we click on the VTour Tab in the media widget it's pane opens and the image pane closes.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function vtourPaneOpens(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_listing&edit=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#listing_image_pane', 30); // secs
        $I->seeElement("#listing_image_pane");
        $I->click("#listing_vtour_tab");
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElementNotVisible("#listing_image_pane");
        $I->seeElement("#listing_vtour_pane");
    }
}
