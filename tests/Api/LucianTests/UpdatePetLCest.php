<?php


namespace Api\LucianTests;

use Tests\Support\ApiTester;

class UpdatePetLCest
{
    public function _before(ApiTester $I)
    {
        $postRequestBody = [
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
        $I->amGoingTo('Send request headers');
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amGoingTo('Send request body');
        $I->sendPost('/pet', json_encode($postRequestBody));
    }


    public function testPostPetById(ApiTester $I)
    {
        $updateRequestBody = [
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
            "status" => "sold"
        ];
        $I->wantToTest('Update pet successfully(status)');

        $I->amGoingTo('Send request headers');
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->amGoingTo('Send request body');
        $I->sendPut('/pet', json_encode($updateRequestBody));

        $I->amGoingTo('Check response');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->amGoingTo('Check response body - option 1');
        $I->seeResponseContainsJson(["id" => 111]);
        $I->seeResponseContainsJson(["status" => "sold"]);

        //or

        $I->amGoingTo('Check response body - option 2');
        $response = json_decode($I->grabResponse(), true);

        $petId = $response["id"];
        $petStatus = $response["status"];
        $I->assertEquals(111, $petId);
        $I->assertEquals("sold", $petStatus);
    }
}
