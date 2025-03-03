<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;


class ProductListLCest {
    public function _before(AcceptanceTester $I){
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');

    }
    public function _after(AcceptanceTester $I){}
    public function succesLogin(AcceptanceTester $I)
    {
        $I->wantToTest('User is redirected to the inventory page after login');
        $I->seeCurrentUrlEquals('/inventory.html');
        $I->see('Products', '.title');
        $I->seeElement('#inventory_container');

    }
    public function addtocart(AcceptanceTester $I)
    {
        $I->wantToTest('Add to cart');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->amOnPage('/inventory.html');
        $I->click('#add-to-cart-sauce-labs-backpack');
   }
    public function removefromcart(AcceptanceTester $I)
    {
        $I->wantToTest('Remove from cart');
        $I->amOnPage('/');
        $I->seeElement('#user-name');
        $I->seeElement('#password');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->amOnPage('/inventory.html');
//        $I->click('#add-to-cart-sauce-labs-backpack');
        $I->click('#remove-sauce-labs-backpack');
        $I->waitForElementNotVisible('#remove-sauce-labs-backpack', 4);
    }
    public function Itemcount(AcceptanceTester $I)
    {
        $I->wantToTest('Add to cart and check cart item count');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->amOnPage('/inventory.html');
        $I->click('#add-to-cart-sauce-labs-backpack');
        $I->waitForElementVisible('.shopping_cart_badge', 2);
        $I->see('1', '.shopping_cart_badge');

    }
    public function NameAtoZ(AcceptanceTester $I)
    {
        $I->wantToTest('Sort by name A to Z');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->amOnPage('/inventory.html');
        $I->click('.product_sort_container');
        $I->click('option[value="az"]');

    }
    public function NameZtoA(AcceptanceTester $I)
    {
        $I->wantToTest('Sort by name Z to A');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->click('.product_sort_container');
        $I->click('option[value="za"]');

    }
    public function PriceLowtoHigh(AcceptanceTester $I){
        $I->wantToTest('Sort by Price Low to High');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->click('.product_sort_container');
        $I->click('option[value="lohi"]');
    }
    public function PriceHightoLow(AcceptanceTester $I){
        $I->wantToTest('Sort by Price High to Low');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->click('.product_sort_container');
        $I->click('option[value="hilo"]');
    }
    public function Productpage(AcceptanceTester $I){
        $I->wantToTest('Product page');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->click('#item_4_img_link > img:nth-child(1)');
        $I->seeCurrentUrlEquals('/inventory-item.html?id=4');
    }
    public function Logout(AcceptanceTester $I){
        $I->wantToTest('Logout');
        $I->amOnPage('/');
        $I->fillField('#user-name', 'standard_user');
        $I->fillField('#password', 'secret_sauce');
        $I->click('#login-button');
        $I->click('#react-burger-menu-btn');
        $I->click('#logout_sidebar_link');
        $I->seeCurrentUrlEquals('/');
        $I->dontSeeCookie('session');
    }
}












