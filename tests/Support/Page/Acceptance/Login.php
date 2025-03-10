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

    public static $URL = '/';
    public static $inventoryURL = '/inventory.html';
    public static $usernameField = '#user-name';
    public static $passwordField = '#password';
    public static $loginButton = '#login-button';
    public static $loginForm = '#login_button_container';
    public static $pageTitle = '.title';
    public static $inventoryContainer = '#inventory_container';
    public static $errorMessage = '.error-message-container.error';
    public static $checkCookie = 'session-username';

    /**
     * @var \Tests\Support\AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\Tests\Support\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }
    public function seeLoginForm(){
        $I = $this->acceptanceTester;

        $I->amOnPage('/');
        $I->seeElement(self::$loginForm);
        $I->seeElement(self::$usernameField);
        $I->seeElement(self::$passwordField);
        $I->seeElement(self::$loginButton);
    }
    public function submitLoginForm($username, $password){
        $I = $this->acceptanceTester;

        $I->amGoingTo('Insert values for username and password & submit');
        $I->fillField(self::$usernameField, $username);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$loginButton);
    }
    public function loginError($outputText) {
        $I = $this->acceptanceTester;

        $I->expectTo('See login form with error message');
        $I->seeCurrentUrlEquals(self::$URL);
        $I->see($outputText, self::$errorMessage);

    }
    public function loginSuccessfully() {
        $I = $this->acceptanceTester;

        $I->expectTo('Login was successful & go to Products page');
        $I->seeInCurrentUrl(self::$inventoryURL);
        $I->see('Products', self::$pageTitle);
        $I->seeElement(self::$inventoryContainer);
        $I->seeCookie(self::$checkCookie);
    }
}
