<?php

declare(strict_types=1);

namespace Tests\Support\Page\Acceptance;

class Login
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */
    public $usernameField = '#user-name';
    public $passwordField = '#password';
    public $loginButton = '#login-button';
    public $loginForm = '#login_button_container';

    /**
     * @var \Tests\Support\AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\Tests\Support\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }

    public function login($username, $password, $outputText) {
        $I = $this->acceptanceTester;

        $I->amOnPage('/');
        $I->seeElement($this->loginForm);

        $I->amGoingTo('Insert values for username and password & submit');
        $I->fillField($this->usernameField, $username);
        $I->fillField($this->passwordField, $password);
        $I->click($this->loginButton);

        $I->expectTo('See login form with error message');
        $I->seeCurrentUrlEquals('/');
        $I->see($outputText, '.error-message-container.error');

    }
    public function loginSuccessfully($username, $password, $outputText) {
        $I = $this->acceptanceTester;

        $I->amOnPage('/');
        $I->seeElement($this->loginForm);

        $I->amGoingTo('Insert values for username and password & submit');
        $I->fillField($this->usernameField, $username);
        $I->fillField($this->passwordField, $password);
        $I->click($this->loginButton);

        $I->expectTo('Login was successful & go to Products page');
        $I->seeInCurrentUrl('/inventory.html');
        $I->see('Products', '.title');
        $I->seeCookie('session-username');
    }
}
