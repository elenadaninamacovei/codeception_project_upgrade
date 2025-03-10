<?php

declare(strict_types=1);

namespace Tests\Support\Page\Acceptance;

use PHPUnit\Framework\Assert;

class Products
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $menuButton = '#react-burger-menu-btn';
    public static $cartButton = '#shopping_cart_container > a';
    public static $filterDropdown = '.product_sort_container';
    public static $filterOptions = '.product_sort_container option';
    public static $cards = '#inventory_container > div > .inventory_item';
    public static $cardName = '.inventory_item .inventory_item_name';
    public static $cardPrice = '.inventory_item .inventory_item_price';
    public static $closeMenuBtn = '#react-burger-cross-btn';
    public static $menuWrap = '#menu_button_container > div > div.bm-menu-wrap';
    public static $backpackAddToCartBtn = '#add-to-cart-sauce-labs-backpack';
    public static $cartAddedProducts = '.shopping_cart_badge';
    public static $allItemsLink= '#inventory_sidebar_link';
    public static $aboutLink = '#about_sidebar_link';
    public static $logoutBtn = '#logout_sidebar_link';
    public static $resetLink = '#reset_sidebar_link';

    /**
     * @var \Tests\Support\AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\Tests\Support\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }
    public function canSeeTopPage(){
        $I = $this->acceptanceTester;

        $I->see('Open Menu', self::$menuButton);
        $I->seeElement(self::$cartButton);
        $I->seeElement(self::$filterDropdown);
        $I->seeElement(self::$cards);
    }
    public function canSeeProductsCard(){
        $I = $this->acceptanceTester;
        $cardItems = $I->grabMultiple(self::$cards);
        Assert::assertGreaterThan(1, count($cardItems), 'Expected multiple elements with the same class');
    }
    public function openMenu(){
        $I = $this->acceptanceTester;
        $I->click(self::$menuButton);

        $I->waitForElementVisible(self::$menuWrap);  // Wait until it is visible
        $I->waitForElementClickable(self::$menuWrap);
    }
    public function canSeeOpenedMenu(){
        $I = $this->acceptanceTester;
        $I->seeElement(self::$menuWrap);
        $I->see('All Items', self::$allItemsLink);
        $I->see('About', self::$aboutLink);
        $I->see('Logout', self::$logoutBtn);
        $I->see('Reset App State', self::$resetLink);
    }
    public function hideMenu(){
        $I = $this->acceptanceTester;
        $I->click(self::$closeMenuBtn);
    }
    public function dontSeeMenu(){
        $I = $this->acceptanceTester;
        $I->dontSeeElement(self::$menuWrap, ['hidden' => true]);
    }
    public function resetAppState(){
        $I = $this->acceptanceTester;
        $I->click(self::$resetLink);
    }
    public function cartEmpty(){
        $I = $this->acceptanceTester;
        $I->dontSeeElement(self::$cartAddedProducts);
    }
    public function addToCart(){
        $I = $this->acceptanceTester;
        $I->click(self::$backpackAddToCartBtn);
    }
    public function productsAddedToCart(){
        $I = $this->acceptanceTester;
        $cartBadgeValue = $I->grabTextFrom(self::$cartAddedProducts);
        $cartBadgeValue = (int) $cartBadgeValue;
        Assert::assertGreaterThanOrEqual(1, $cartBadgeValue, 'The product was added to the cart.');
    }
    public function openFilters() {
        $I = $this->acceptanceTester;
        $I->click(self::$filterDropdown);
    }
    public function checkFilterOptions(){
        $I = $this->acceptanceTester;
        $options = $I->grabMultiple(self::$filterOptions);
        Assert::assertContains('Name (A to Z)', $options);
        Assert::assertContains('Name (Z to A)', $options);
        Assert::assertContains('Price (low to high)', $options);
        Assert::assertContains('Price (high to low)', $options);
    }
    public function selectFilterOption($selectedOption){
        $I = $this->acceptanceTester;
        $I->selectOption(self::$filterDropdown, $selectedOption);
    }
    public function productsSortedByName(callable $sortFunction, string $message){
        $I = $this->acceptanceTester;
        $cardNames = $I->grabMultiple(self::$cardName);
        $sortedOptions = $cardNames;
        $sortFunction($sortedOptions);
        Assert::assertEquals($cardNames, $sortedOptions, $message);
    }

    public function productsSortedByPrice(callable $sortFunction, string $message) {
        $I = $this->acceptanceTester;
        $cardPrice = $I->grabMultiple(self::$cardPrice);
        $cardPrice = array_map(function($price) {
            return (float) str_replace('$', '', $price);  // Remove the '$' symbol and convert to float
        }, $cardPrice);

        $sortedOptions = $cardPrice;
        $sortFunction($sortedOptions);
        Assert::assertEquals($cardPrice, $sortedOptions, $message);
    }
}
