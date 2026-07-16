<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */
    public function adminLogin($name, $password)
    {
        $I = $this;
        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot($name)) {
            return;
        }
        // logging in
        $I->amOnPage('/admin');
        // We need to do actual user fill instad of SumbitForm due to hidden CSRF tokens.
        $I->fillField('user_name', 'admin');
        $I->fillField('user_pass', 'password');
        $I->click('.login_button');
        $I->waitForElement('.or_index', 30); // secs
        $I->see('Logout');
    }
}
