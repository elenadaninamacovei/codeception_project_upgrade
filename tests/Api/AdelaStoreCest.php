<?php

namespace Tests\Api;

use Tests\Support\ApiTester;

class AdelaStoreCest
{
    
    public function _before(ApiTester $I){
        $this->addOrder = [
            "id" => 7,
            "petId" => 99,
            "quantity" => 1,
            "shipDate" => "2025-03-31T21:52:21.210Z",
            "status" => "placed",
            "complete" => true
        ];

        $this->getById = '7';
    }
    public function getInventory(ApiTester $I){
        $I->wantToTest('Retrieve user successfully');

        $I->addHeaders();

        $I->sendGetRequest('/store/inventory');

        $I->checkResponseSuccessfull();

        $I->seeResponseMatchesJsonType(['BerneseMountainDog' => 'integer']);
    }

    public function addOrder(ApiTester $I){
        $I->addHeaders();
        $I->sendPostRequest('/store/order', $this->addOrder);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody([
            "id" => $this->addOrder['id'],
            "petId" => $this->addOrder['petId'],
            "quantity" => $this->addOrder['quantity'],
            "status" => $this->addOrder['status'],
            "complete" => $this->addOrder['complete']
        ]);
    }

    public function retrieveOrder(ApiTester $I){
        $I->addHeaders();
        $I->sendGetRequest('/store/order/'.$this->getById);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody([
            "id" => $this->addOrder['id'],
            "petId" => $this->addOrder['petId'],
            "quantity" => $this->addOrder['quantity'],
            "status" => $this->addOrder['status'],
            "complete" => $this->addOrder['complete']
        ]);
    }

    public function deleteOrder(ApiTester $I){
        $I->addHeaders();
        $I->sendDeleteRequest('/store/order/'.$this->getById);
        
        $I->checkResponseSuccessfull();

        $I->checkResponseBody(['code' => 200, 'message' => $this->addOrder['id']]); 
    }
}