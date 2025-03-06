<?php

namespace Tests\Support\Page\Acceptance\LucianPOM;;




use Codeception\Lib\Generator\PageObject;
use Tests\Support\AcceptanceTester;

class InventoryLPage extends PageObject
{
    public static $AddCartButton = '#add-to-cart-sauce-labs-backpack'; //click
    public static $RemoveCartButoon = '#remove-sauce-labs-backpack'; //click
    public static $CartBadge = '.shopping_cart_badge'; //see
    public static $sortButton = '.product_sort_container'; //click
    public static $sortAZ = 'option[value="az"]'; //click
    public static $sortZA = 'option[value="za"]'; //click
    public static $sortHILO = 'option[value="hilo"]'; //click
    public static $sortLOHI = 'option[value="lohi"]'; //click
    public static $productpage = '#item_4_img_link > img:nth-child(1)'; //see
    public static $item4url = '/inventory-item.html?id=4'; //see

    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }
    public function Addtocart()
    {
        $I = $this->acceptanceTester;
        $I->click(self::$AddCartButton);
    }
    public function Removefromcart(){
        $I = $this->acceptanceTester;
        $I->click(self::$RemoveCartButoon);
    }
    public function seeCartBadge(){
        $I = $this->acceptanceTester;
        $I->see(self::$CartBadge);
    }
    public function sortButton(){
        $I = $this->acceptanceTester;
        $I->click(self::$sortButton);

    }
    public function sortAZ(){
        $I = $this->acceptanceTester;
        $I->click(self::$sortAZ);
    }
    public function sortZA(){
        $I = $this->acceptanceTester;
        $I->click(self::$sortZA);
    }
    public function sortHILO(){
        $I = $this->acceptanceTester;
        $I->click(self::$sortHILO);
    }
    public function sortLOHI(){
        $I = $this->acceptanceTester;
        $I->click(self::$sortLOHI);
    }
    public function ProductPage(){
        $I = $this->acceptanceTester;
        $I->click(self::$productpage);
    }
    public function seeItem4Url(){
        $I = $this->acceptanceTester;
        $I->see(self::$item4url);
    }
    public function seeCartItemCount(int $expectedCount): void
    {
        $this->I->see((string)$expectedCount, self::$cartBadge);
    }
}