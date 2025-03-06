<?php

namespace Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\LoginPage;

class LoginUsePOMCest
{

    public function successfulLogin(AcceptanceTester $I)
    {
        $I->wantToTest('Successful login with a valid user redirects to products listing page');
        $loginPage = new LoginPage($I);

        // accesam pagina www.saucedemo.com
        // $I->amOnPage('/');
        $loginPage->accessLoginPage();

        // verificam ca exista formularul de login in pagina
        // $I->seeElement('.login_wrapper');
        $loginPage->seeLoginForm();

        // verificam ca exista campul "username"
        // $I->seeElement('#user-name');
        $loginPage->seeUsername();

        // verificam ca exista campul "password"
        // $I->seeElement('#password');
        $loginPage->seePassword();

        // in campul "username" introduc un username valid: standard_user
        // $I->fillField('#user-name', 'standard_user');
        $loginPage->fillUsername($_ENV['STANDARD_USER']);

        // in campul "password" introduc o parola valida: secret_sauce
        // $I->fillField('#password', 'secret_sauce');
        $loginPage->fillPassword($_ENV['PASSWORD']);

        // click pe butonul de Login
        // $I->click('#login-button');
        $loginPage->clickLoginButton();

        // verific ca am fost directionat spre /inventory.html
        // $I->seeInCurrentUrl('/inventory.html');
        $loginPage->seeInventoryPage();

        // verific ca este listata pagina de produse
        // $I->see('Products', '.title');
        // $I->seeElement('#inventory_container');
        $loginPage->seeProductsListed();

        // verific ca a fost setat cookie "session-username" cu username-ul utilizatorului
        // $I->seeCookie('session-username');
        // $cookieValue = $I->grabCookie('session-username');
        // Assert::assertEquals('standard_user', $cookieValue);
        $loginPage->seeCookie();
    }

    public function invalidUsername(AcceptanceTester $I)
    {
        $I->wantToTest('Login with an invalid username should display an error message and stay on the homepage');
        $loginPage = new LoginPage($I);

        // $I->amOnPage('/');
        $loginPage->accessLoginPage();

        $I->amGoingTo('Insert invalid credentials & submit');
//        $I->fillField('#user-name', 'invalid_user');
//        $I->fillField('#password', 'secret_sauce');
//        $I->click('#login-button');
        $loginPage->fillUsername($_ENV['INVALID_USER']);
        $loginPage->fillPassword($_ENV['PASSWORD']);
        $loginPage->clickLoginButton();

        $I->amGoingTo('Check I am on the same page & validation message appears');
        $I->seeCurrentUrlEquals('/');
        $I->dontSeeCookie('session-username');
//        $I->see('Epic sadface: Username and password do not match any user in this service', '.error-message-container.error');
        $loginPage->seeErrorMessage('Epic sadface: Username and password do not match any user in this service');
    }
}