<?php

namespace Acceptance;

use Tests\Support\AcceptanceTester;
use \Tests\Support\Page\Acceptance\Login;
class LoginAdelaCest
{
    public function successfullLogin(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Successful login using registered username and password');

        $loginPage->seeLoginForm();
        $loginPage->submitLoginForm($_ENV['VALID_USERNAME'],$_ENV['VALID_PASSWORD']);

        $loginPage->loginSuccessfully();
    }
    public function invalidCredentials(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with incorrect username and password');

        $loginPage->seeLoginForm();
        $loginPage->submitLoginForm($_ENV['INVALID_USERNAME'],$_ENV['INVALID_PASSWORD']);

        $loginPage->loginError('Epic sadface: Username and password do not match any user in this service');
    }

    public function emptyInputs(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with empty inputs for username and password');

        $loginPage->seeLoginForm();
        $loginPage->submitLoginForm('','');

        $loginPage->loginError('Epic sadface: Username is required');
    }

    public function swappedCredentials(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with username in password field and password in username field');

        $loginPage->seeLoginForm();
        $loginPage->submitLoginForm($_ENV['VALID_PASSWORD'],$_ENV['VALID_USERNAME']);

        $loginPage->loginError('Epic sadface: Username and password do not match any user in this service');
    }

    public function lockedOutUser(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with locked out user');

        $loginPage->seeLoginForm();
        $loginPage->submitLoginForm($_ENV['LOCKED_OUT_USER'],$_ENV['VALID_PASSWORD']);

        $loginPage->loginError('Epic sadface: Sorry, this user has been locked out.');
    }
}