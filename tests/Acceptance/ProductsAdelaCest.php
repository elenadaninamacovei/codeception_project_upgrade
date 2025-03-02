<?php

namespace Acceptance;

use Tests\Support\AcceptanceTester;
use \Tests\Support\Page\Acceptance\Login;
class ProductsAdelaCest
{
    public function accessProductsPage(AcceptanceTester $I, Login $loginPage){
        $loginPage->loginSuccessfully(
            'standard_user',
            'secret_sauce',
            'Epic sadface: Username and password do not match any user in this service'
        );

        $I->expectTo('See products page');

        $I->amOnPage('/inventory.html');

        $I->see('Open Menu', '#react-burger-menu-btn');

        $I->seeElement('#shopping_cart_container > a');
    }



    public function openMenu(AcceptanceTester $I){
        $I->expectTo('To open the menu and see four options');
        $I->click('#react-burger-menu-btn');
        $I->see('Open Menu', '#react-burger-menu-btn');
        $I->seeElement('#menu_button_container > div > div.bm-menu-wrap');
        $I->see('All Items', '#inventory_sidebar_link');
        $I->see('About', '#about_sidebar_link');
        $I->see('Logout', '#logout_sidebar_link');
        $I->see('Reset App State', '#reset_sidebar_link');
    }

    public function closeMenu(AcceptanceTester $I) {
        $I->click('#inventory_container');
        $I->dontSeeElement('#menu_button_container > div > div.bm-menu-wrap');
    }

    public function openMenuAgain(AcceptanceTester $I){
        $I->expectTo('To open the menu and see four options');
        $I->click('#react-burger-menu-btn');
        $I->see('Open Menu', '#react-burger-menu-btn');
        $I->seeElement('#menu_button_container > div > div.bm-menu-wrap');
        $I->see('All Items', '#inventory_sidebar_link');
        $I->see('About', '#about_sidebar_link');
        $I->see('Logout', '#logout_sidebar_link');
        $I->see('Reset App State', '#reset_sidebar_link');
    }

    public function logoutUser(AcceptanceTester $I){
        $I->click('#logout_sidebar_link');
        $I->amOnPage('/');
        $I->seeElement('#login_button_container');
    }

}