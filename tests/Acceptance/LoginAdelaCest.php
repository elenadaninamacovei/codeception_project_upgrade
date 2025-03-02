<?php

namespace Acceptance;

use Tests\Support\AcceptanceTester;
use \Tests\Support\Page\Acceptance\Login;
class LoginAdelaCest
{
    public function successfullLogin(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Successful login using registered username and password');

        $loginPage->loginSuccessfully(
            'standard_user',
            'secret_sauce',
            'Epic sadface: Username and password do not match any user in this service'
        );
    }
    public function invalidCredentials(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with incorrect username and password');

        $loginPage->login(
            'user_incorrect',
            'wrong_password',
            'Epic sadface: Username and password do not match any user in this service'
        );
    }

    public function emptyInputs(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with empty inputs for username and password');

        $loginPage->login(
            '',
            '',
            'Epic sadface: Username is required'
        );
    }

    public function swappedCredentials(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with username in password field and password in username field');

        $loginPage->login(
            'secret_sauce',
            'standard_user',
            'Epic sadface: Username and password do not match any user in this service'
        );
    }

    public function lockedOutUser(AcceptanceTester $I, Login $loginPage) {

        $I->wantToTest('Unsuccessful login with locked out user');

        $loginPage->login(
            'locked_out_user',
            'secret_sauce',
            'Epic sadface: Sorry, this user has been locked out.'
        );
    }
}