<?php

namespace Acceptance\ExampleTests;

use Tests\Support\AcceptanceTester;

class FirstCest
{
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Swag Labs');
    }
}
