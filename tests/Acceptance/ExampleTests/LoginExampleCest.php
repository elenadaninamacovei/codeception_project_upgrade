<?php

namespace Acceptance\ExampleTests;

use PHPUnit\Framework\Assert;
use Tests\Support\AcceptanceTester;

class LoginExampleCest
{

    public function successfulLogin(AcceptanceTester $I)
    {
        $I->wantToTest('Successful login with a valid user redirects to products listing page');
        // accesam pagina www.saucedemo.com
        $I->amOnPage('/');

        // verificam ca exista formularul de login in pagina
        $I->seeElement('.login_wrapper');

        // verificam ca exista campul "username"
        $I->seeElement('#user-name');

        // verificam ca exista campul "password"
        $I->seeElement('#password');

        // in campul "username" introduc un username valid: standard_user
        $I->fillField('#user-name', 'standard_user');

        // in campul "password" introduc o parola valida: secret_sauce
        $I->fillField('#password', 'secret_sauce');

        // click pe butonul de Login
        $I->click('#login-button');

        // verific ca am fost directionat spre /inventory.html
        $I->seeInCurrentUrl('/inventory.html');

        // verific ca este listat pagina de produse
        $I->see('Products', '.title');
        $I->seeElement('#inventory_container');

        // verific ca a fost setat cookie "session-username" cu username-ul utilizatorului
        $I->seeCookie('session-username');
        $cookieValue = $I->grabCookie('session-username');
        Assert::assertEquals('standard_user', $cookieValue);
    }

    public function invalidUsername(AcceptanceTester $I)
    {
        $I->wantToTest('Login with an invalid username should display an error message and stay on the homepage');
        $I->amOnPage('/');

        $I->amGoingTo('Insert invalid credentials & submit');
        $I->fillField('#user-name', 'invalid_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');

        $I->seeCurrentUrlEquals('/');
        $I->see('Epic sadface: Username and password do not match any user in this service', '.error-message-container.error');
        $I->dontSeeCookie('session-username');
    }
}