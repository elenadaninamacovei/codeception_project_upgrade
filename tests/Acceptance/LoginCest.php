<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class LoginCest {

    public function successfulLogin(AcceptanceTester $I) {
        $I->wantToTest('Successful login with a valid user redirects to products listing page');
        $I->amOnPage('/');

        $I->amGoingTo('Insert a valid username and password & submit');
        $I->fillField('#user-name', 'standard_user'); // Selectors: #id > .class > XPath
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->expectTo('Submit form');

        $I->expectTo('Login was successful & go to Products page');
        $I->seeInCurrentUrl('/inventory.html');
        $I->see('Products', '.title');
    }
}