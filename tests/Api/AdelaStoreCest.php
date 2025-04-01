<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use \Tests\Support\Page\Api\Store;
use \Tests\Support\Page\Api\SendRequests;
use \Tests\Support\Page\Api\SetHeaders;

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
    }
    public function getInventory(ApiTester $I, Store $store, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Retrieve user successfully');

        $setHeader->addHeaders();

        $sendRequest->sendGetRequest('/store/inventory');

        $store->checkResponseSuccessfull();

        $I->seeResponseMatchesJsonType(['BerneseMountainDog' => 'integer']);
    }

    public function addOrder(ApiTester $I, Store $store, SendRequests $sendRequest, SetHeaders $setHeader){
        $setHeader->addHeaders();
        $sendRequest->sendPostRequest('/store/order', $this->addOrder);
        $store->checkResponseSuccessfull();

        $I->amGoingTo('Check response body');
        $I->seeResponseContainsJson([
            "id" => $this->addOrder['id'],
            "petId" => $this->addOrder['petId'],
            "quantity" => $this->addOrder['quantity'],
            "status" => $this->addOrder['status'],
            "complete" => $this->addOrder['complete']
        ]);
    }

    public function retrieveOrder(ApiTester $I, Store $store, SendRequests $sendRequest, SetHeaders $setHeader){
        $setHeader->addHeaders();
        $sendRequest->sendGetRequest('/store/order/7');
        $store->checkResponseSuccessfull();

        $I->amGoingTo('Check response body');
        $I->seeResponseContainsJson([
            "id" => $this->addOrder['id'],
            "petId" => $this->addOrder['petId'],
            "quantity" => $this->addOrder['quantity'],
            "status" => $this->addOrder['status'],
            "complete" => $this->addOrder['complete']
        ]);
    }

    public function deleteOrder(ApiTester $I, Store $store, SendRequests $sendRequest, SetHeaders $setHeader){
        $setHeader->addHeaders();
        $sendRequest->sendDeleteRequest('/store/order/7');
        $store->checkResponseSuccessfull();

        $I->amGoingTo('Check response body');
        $I->seeResponseContainsJson(['code' => 200]);
        $I->seeResponseContainsJson(['message' => $this->addOrder['id']]);
    }
}