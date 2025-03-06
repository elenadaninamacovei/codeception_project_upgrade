<?php

namespace Tests\Support\Page\Acceptance;

use Codeception\Lib\Generator\PageObject;
use Facebook\WebDriver\WebDriverKeys;
use PHPUnit\Framework\Assert;
use Tests\Support\AcceptanceTester;

class LoginPage extends PageObject
{
    // Selectors
    public static $URL = '/';
    public static $loginForm = '.login_wrapper';
    public static $usernameField = '#user-name';
    public static $passwordField = '#password';
    public static $loginButton = '#login-button';
    public static $pageTitle = '.title';
    public static $inventoryContainer = '#inventory_container';
    public static $errorMessage = '.error-message-container.error';
    public static $deleteErrrorMessage = 'svg.svg-inline--fa:nth-child(1) > path:nth-child(1)';
    public function alreadyLogin()
    {
        $I = $this->acceptanceTester;
        $I->amOnPage('/');
        $I->seeElement(self::$usernameField);
        $I->seeElement(self::$passwordField);
        $I->fillField(self::$usernameField, $_ENV['STANDARD_USER']);
        $I->fillField(self::$passwordField, $_ENV['PASSWORD']);
        $I->click(self::$loginButton);
        $I->seeInCurrentUrl('/inventory.html');
    }
    public static $TABkey = 'WebDriverKeys::TAB)';
    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function accessLoginPage()
    {
        $I = $this->acceptanceTester;
        $I->amOnPage('/');
    }

    public function seeLoginForm()
    {
        $I = $this->acceptanceTester;
        $I->seeElement(self::$loginForm);
    }

    public function seeUsername()
    {
        $I = $this->acceptanceTester;
        $I->seeElement(self::$usernameField);
    }

    public function seePassword()
    {
        $I = $this->acceptanceTester;
        $I->seeElement(self::$passwordField);
    }
    public function fillUsername($username)
    {
        $I = $this->acceptanceTester;
        $I->fillField(self::$usernameField, $username);
    }

    public function fillPassword($password)
    {
        $I = $this->acceptanceTester;
        $I->fillField(self::$passwordField, $password);
    }

    public function clickLoginButton()
    {
        $I = $this->acceptanceTester;
        $I->click(self::$loginButton);
    }

    public function seeInventoryPage()
    {
        $I = $this->acceptanceTester;
        $I->seeInCurrentUrl('/inventory.html');
    }

    public function seeProductsListed()
    {
        $I = $this->acceptanceTester;
        $I->see('Products', self::$pageTitle);
        $I->seeElement(self::$inventoryContainer);
    }

    public function seeCookie()
    {
        $I = $this->acceptanceTester;
        $I->seeCookie('session-username');
        $cookieValue = $I->grabCookie('session-username');
        Assert::assertEquals('standard_user', $cookieValue);
    }

    public function seeErrorMessage($message)
    {
        $I = $this->acceptanceTester;
        $I->see($message, self::$errorMessage);
    }
    public function deleteErrorMessage()
    {
        $I = $this->acceptanceTester;
        $I->click(self::$deleteErrrorMessage);
    }
    public function TabKey()
    {
        $I = $this->acceptanceTester;
        $I->pressKey(self::$usernameField, WebDriverKeys::TAB);
    }


}
