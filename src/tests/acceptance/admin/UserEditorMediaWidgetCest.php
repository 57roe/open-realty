<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../testSetup.php';

/**
 * Acceptance Test for the User Editor's Media Widget
 */
class UserEditorMediaWidgetCest extends testSetup
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
     * Check that on page load only the image pane is open.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function defaultOnlyImagePaneVisible(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_user&user_id=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#user_image_pane', 30); // secs
        $I->seeElement("#user_image_pane");
        $I->dontSeeElement("#user_file_pane");
    }
    
    /**
     * Check that on click of the file tab, the image pane closes and the file pane opens.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function filePaneOpens(AcceptanceTester $I)
    {
        $I->adminLogin('admin', 'password');
        $I->amOnPage('/admin/index.php?action=edit_user&user_id=1');
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElement('#user_image_pane', 30); // secs
        $I->seeElement("#user_image_pane");
        $I->click("#user_file_tab");
        $I->waitForJS("return $.active == 0;", 60); // Wait for all ajax calls to complete
        $I->waitForElementNotVisible("#user_image_pane");
        $I->seeElement("#user_file_pane");
    }
}
