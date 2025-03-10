<?php

namespace Acceptance;

use Tests\Support\AcceptanceTester;
use \Tests\Support\Page\Acceptance\Login;
use \Tests\Support\Page\Acceptance\Products;

use PHPUnit\Framework\Assert;
class ProductsAdelaCest
{
    public function accessProductsPage(AcceptanceTester $I, Login $loginPage, Products $productsPage)
    {
        $loginPage->seeLoginForm();
        $loginPage->submitLoginForm($_ENV['VALID_USERNAME'], $_ENV['VALID_PASSWORD']);

        $loginPage->loginSuccessfully();

        $productsPage->canSeeTopPage();
        $productsPage->canSeeProductsCard();
    }
    public function openMenu(AcceptanceTester $I, Products $productsPage){
        $I->expectTo('To open the menu and see four options');

        $productsPage->openMenu();

        $productsPage->canSeeOpenedMenu();
    }
    public function closeMenu(AcceptanceTester $I, Products $productsPage) {
        $I->expectTo('To close the menu');
        $productsPage->hideMenu();
        $productsPage->dontSeeMenu();
    }
    public function resetApp(AcceptanceTester $I, Products $productsPage) {
        $productsPage->addToCart();

        $productsPage->productsAddedToCart();
        $productsPage->openMenu();

        $productsPage->resetAppState();
        $productsPage->hideMenu();
        $productsPage->cartEmpty();
    }

    public function checkFilters(AcceptanceTester $I, Products $productsPage){
        $productsPage->openFilters();

        $productsPage->checkFilterOptions();
    }
    public function sortByName(AcceptanceTester $I, Products $productsPage){
        $productsPage->openFilters();

        $productsPage->selectFilterOption('za');

        $productsPage->productsSortedByName('rsort','The product names are sorted from Z to A.');
    }
    public function sortByPrice(AcceptanceTester $I, Products $productsPage){
        $productsPage->openFilters();

        $productsPage->selectFilterOption('hilo');
        $productsPage->productsSortedByPrice('rsort', 'The product price are sorted from high to low.');


    }
}