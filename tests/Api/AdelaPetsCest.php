<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use \Codeception\Attribute\DataProvider;
use \Codeception\Example;


class AdelaPetsCest
{

        /**
     * Data provider for adding pet data
     * 
     * @return array
     */
    protected function addPetData(){
      return [
        [ 
          'data' => [
            "id" => 98,
            "category" => [
              "id" => 0,
              "name" => "Mountain dog 1"
            ],
            "name" => "BerneseMountainDog 1",
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
          ]
        ],
        [
          'data' => [
            "id" => 99,
            "category" => [
              "id" => 0,
              "name" => "Mountain dog 2"
            ],
            "name" => "BerneseMountainDog 2",
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
          ]
        ]
      ];
    }
    /**
     * Test user creation with multiple sets of data using the data provider.
     * 
     * @dataProvider addPetData
     */
    public function addPet(ApiTester $I, \Codeception\Example $example){
      
        $I->wantToTest('Create pet successfully');

        $I->addHeaders();

        $I->sendPostRequest('/pet', $example['data']);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody(['name' => $example['data']['name'], 'category' => $example['data']['category'], 'status' => $example['data']['status']]);
    }
}