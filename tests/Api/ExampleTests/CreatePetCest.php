<?php

namespace Api\ExampleTests;

use Tests\Support\ApiTester;
use Tests\Support\Page\Api\Routes as Route;

class CreatePetCest
{
    public function _before(ApiTester $I){
        $this->requestBody = [
            "id" => 111,
            "category" => [
                "id" => 1,
                "name" => "Dog"
            ],
            "name" => "Akita",
            "photoUrls" => [
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCzjsWKVXgGq6-yjP_G3HaOkPtx7nABs7VeQ&s"
            ],
            "tags" => [
                [
                    "id" => 1,
                    "name" => "agitat"
                ],
                [
                    "id" => 2,
                    "name" => "independent"
                ]
            ],
            "status" => "available"
        ];
    }

    public function testPostPetById(ApiTester $I)
    {
        $I->wantToTest('Create pet successfully');

        $I->amGoingTo('Send request headers');
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->amGoingTo('Send request body');
        $I->sendPost(Route::PET, json_encode($this->requestBody));

        $I->amGoingTo('Check response');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->amGoingTo('Check response body - option 1');
        $I->seeResponseContainsJson(["id" => 111]);
        $I->seeResponseContainsJson(["status" => "available"]);

        //or

        $I->amGoingTo('Check response body - option 2');
        $response = json_decode($I->grabResponse(), true);

        $petId = $response["id"];
        $petStatus = $response["status"];
        $I->assertEquals(111, $petId);
        $I->assertEquals("available", $petStatus);
    }
}
