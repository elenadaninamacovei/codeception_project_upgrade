<?php

namespace Acceptance\LucianTests;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\LucianPOM\InventoryLPage;
use Tests\Support\Page\Acceptance\LucianPOM\LoginLPage;

class LoginLwithPOMCest
{

    public function successfulLogin(AcceptanceTester $I)
    {
        $I->wantToTest('Login with valid data');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->accessLoginPage();
        $loginPage->fillUsername($_ENV['STANDARD_USER']);
        $loginPage->fillPassword($_ENV['PASSWORD']);
        $loginPage->clickLoginButton();
        $loginPage->seeInventoryPage();
        $loginPage->seeProductsListed();
    }
    public function invalidUsername(AcceptanceTester $I)
    {
        $I->wantToTest('Login with wrong username, correct password');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->accessLoginPage();
        $I->amGoingTo('Insert invalid credentials & submit');
        $loginPage->fillUsername('invalid_user');
        $loginPage->fillPassword($_ENV['PASSWORD']);
        $loginPage->clickLoginButton();
        $loginPage->seeErrorMessage('Epic sadface: Username and password do not match any user in this service');

    }
    public function invalidPassword(AcceptanceTester $I)
    {
        $I->wantToTest('Login with correct username, wrong password');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->accessLoginPage();
        $loginPage->fillUsername($_ENV['STANDARD_USER']);
        $loginPage->fillPassword($_ENV['WRONG_PASSWORD']);
        $loginPage->clickLoginButton();
        $loginPage->seeErrorMessage('Epic sadface: Username and password do not match any user in this service');
    }
    public function emtpyLogin(AcceptanceTester $I)
    {
        $I->wantToTest('Login without data');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->accessLoginPage();  //<------- daca sterg de la stanga la dreapta din mesaj primesc eroare, daca sterg de la dreapta la stanga nu primesc??
        $loginPage->clickLoginButton();
        $loginPage->seeErrorMessage('Epic sadface: Username is required');
    }
    public function lockeduser(AcceptanceTester $I)
    {
        $I->wantToTest('Login with locked user');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->accessLoginPage();
        $loginPage->fillUsername($_ENV['LOCKED_USER']);
        $loginPage->fillPassword($_ENV['PASSWORD']);
        $loginPage->clickLoginButton();
        $loginPage->seeErrorMessage('Epic sadface: Sorry, this user has been locked out.');
    }
    public function deleteErrorLoginMessage(AcceptanceTester $I)
    {
        $I->wantToTest('Delete error message');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->accessLoginPage();
        $loginPage->fillUsername($_ENV['INVALID_USER']);
        $loginPage->fillPassword($_ENV['PASSWORD']);
        $loginPage->clickLoginButton();
        $loginPage->seeErrorMessage('Epic sadface: Username and password do not match any user in this service');
        $loginPage->deleteErrorMessage();
        $loginPage->clickLoginButton();
        $loginPage->seeErrorMessage('Epic sadface: Username and password do not match any user in this service');
    }
    public function NavigateWithTAB(AcceptanceTester $I){
        $I->wantToTest('NAVIGATE WITH TAB');
        $loginPage = new LoginLPage($I);
        $loginPage->accessLoginPage();
        $loginPage->seeLoginForm();
        $loginPage->seeUsername();
        $I->wait(2);
        $loginPage->TabKey();
        $I->wait(2);

    }
    //---------------------------------------------------------------------------------------------------------------
    public function Addtocart(AcceptanceTester $I){
        $loginPage = new LoginLPage($I);
        $loginPage->alreadyLogin();
        $InventoryPageL= new InventoryLPage($I);
        $InventoryPageL->Addtocart();
    }
    public function Removefromcart(AcceptanceTester $I){
        $loginPage = new LoginLPage($I);
        $loginPage->alreadyLogin();
        $InventoryPageL= new InventoryLPage($I);
        $InventoryPageL->Addtocart();
        $InventoryPageL->Removefromcart();
    }
//    public function itemcount(AcceptanceTester $I){
//        $loginPage = new LoginPage($I);
//        $loginPage->alreadyLogin();
//        $InventoryPageL= new InventoryPageL($I);
//        $InventoryPageL->Addtocart();
//        $InventoryPageL->seeCartItemCount(1);
//    }
    public function sort(AcceptanceTester $I){
        $loginPage = new LoginLPage($I);
        $loginPage->alreadyLogin();
        $InventoryPageL= new InventoryLPage($I);
        $InventoryPageL->sortButton();
        $InventoryPageL->sortAZ();
        $I->wait(1);
        $InventoryPageL->sortButton();
        $InventoryPageL->sortZA();
        $I->wait(1);
        $InventoryPageL->sortButton();
        $InventoryPageL->sortLOHI();
        $I->wait(1);
        $InventoryPageL->sortButton();
        $InventoryPageL->sortHILO();
        $I->wait(1);

    }


}