<?php

namespace Api\ExampleTests;

use Tests\Support\ApiTester;

class FirstCest
{
    public function testGetPetById(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->sendGET('/pet/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }
}
