<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use \Tests\Support\Page\Api\Store;
use \Tests\Support\Page\Api\SendRequests;
use \Tests\Support\Page\Api\SetHeaders;

class AdelaPetsCest
{

    public function _before(ApiTester $I){
        $this->AddPetRequeste = [
            "id" => 99,
            "category" => [
              "id" => 0,
              "name" => "Mountain dog"
            ],
            "name" => "BerneseMountainDog",
            "photoUrls" => [
              "BerneseMountainDogImage"
            ],
            "tags" => [
              [
                "id" => 0,
                "name" => "bernese"
              ],
              [
                "id" => 1,
                "name" => "mountain"
              ],
              [
                "id" => 2,
                "name" => "dog"
              ]
            ],
            "status" => "BerneseMountainDog"
        ];
    }
    public function addPet(ApiTester $I, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Create pet successfully');

        $setHeader->addHeaders();

        $sendRequest->sendPostRequest('/pet', $this->AddPetRequeste);

        $I->amGoingTo('Check response');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->amGoingTo('Check response body');
        $I->seeResponseContainsJson($this->AddPetRequeste);
    }
}