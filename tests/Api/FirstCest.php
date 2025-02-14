<?php

namespace Tests\Api;

use Tests\Support\ApiTester;

class FirstCest
{
    public function testGetPetById(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->sendGET('/pet/1234');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }
}
