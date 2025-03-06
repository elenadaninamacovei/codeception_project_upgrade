<?php

namespace Acceptance\LucianTests;

use Facebook\WebDriver\WebDriverKeys;
use Tests\Support\AcceptanceTester;

class LoginLCest {

    public function lockedPage(AcceptanceTester $I) {
        $I->wantToTest('Locked user can`t login');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'locked_out_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->see("Epic sadface: Sorry, this user has been locked out.", '.error-message-container' );
        $I->dontSeeCookie('session');

    }
    public function emptylogin(AcceptanceTester $I) {
        $I->wantToTest('Login without data ');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->click('#login-button');
        $I->see('Epic sadface: Username is required',".error-message-container");

    }
    public function validLogin(AcceptanceTester $I)
    {
        $I->wantToTest('Login with valid data');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->seeCurrentUrlEquals('/inventory.html');
        $I->see('Products', '.title');
        $I->seeElement('#inventory_container');

    }
    public function invaliduser(AcceptanceTester $I){
        $I->wantToTest('Login with wrong username, correct password');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'iuser');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->seeCurrentUrlEquals('/');
        $I->see('Epic sadface: Username and password do not match any user in this service', '.error-message-container.error');
    }
    public function invalidpassword(AcceptanceTester $I){
        $I->wantToTest('Login with correct username, wrong password');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'gresit');
        $I->click('#login-button');
        $I->see('Epic sadface: Username and password do not match any user in this service', '.error-message-container.error');
    }
    public function deleteErrorLoginMessage(AcceptanceTester $I)
    {
        $I->wantToTest('Login with correct username, wrong password');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'gresit');
        $I->click('#login-button');
        $I->click('svg.svg-inline--fa:nth-child(1) > path:nth-child(1)');
        $I->click('#login-button');
        $I->see('Epic sadface: Username and password do not match any user in this service', '.error-message-container.error');
        $I->amOnPage('/');
    }
    public function NavigateWithTAB(AcceptanceTester $I){
        $I->wantToTest('NAVIGATE WITH TAB');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->pressKey('#user-name', WebDriverKeys::TAB);
        $I->seeElement('#password');
    }

    public function copyPastePasswordOnUsername(AcceptanceTester $I)
    {
        $I->wantToTest('User cannot copy password and paste it into the username field');
        // Open the login page
        $I->amOnPage('/');
        // Verify fields exist
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        // Fill in the password field
        $I->fillField('password', 'gresit');
        // Attempt to copy the password value using the Clipboard API
        $I->executeJS("
        if (navigator.clipboard) {
            navigator.clipboard.writeText(document.getElementById('password').value);
        }
    ");
        // Try pasting the password into the username field
        $I->executeJS("
        if (navigator.clipboard && navigator.clipboard.readText) {
            navigator.clipboard.readText().then(function(text) {
                document.getElementById('password').value = text;
            });
        }
    ");
        // Assert that the username field does not contain the password
        $I->dontSeeInField('#user-name', 'gresit');
    }
}