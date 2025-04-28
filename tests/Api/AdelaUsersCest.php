<?php

namespace Tests\Api;

use Tests\Support\ApiTester;

class AdelaUsersCest
{

    public function _before(ApiTester $I){
        $this->requestAddUser = [
            [
                "id" => 99,
                "username" => "BoldeanuAdela",
                "firstName" => "Boldeanu",
                "lastName" => "Adela",
                "email" => "adela.boldeanu@yahoo.ro",
                "password" => "DoctorWho",
                "phone" => "0734674321",
                "userStatus" => 0
            ]
        ];

        $this->requestUpdateUser = [
            "id" => 99,
            "username" => "BoldeanuAdelaUpdate",
            "firstName" => "BoldeanuUpdate",
            "lastName" => "AdelaUpdate",
            "email" => "adela.update@yahoo.ro",
            "password" => "DoctorWho",
            "phone" => "0734674321",
            "userStatus" => 0
        ];

        $this->nonexistingUser = 'testBoldeanuAdelaTest';
    }

    public function addNewUserSuccessfully(ApiTester $I){
        $I->wantToTest('Create user successfully');

        $I->addHeaders();

        $I->sendPostRequest('/user/createWithList', $this->requestAddUser);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody(["code" => 200, "message" => "ok"]);
    }

    public function retrieveUser(ApiTester $I){
        $I->wantToTest('Retrieve user successfully');

        $I->addHeaders();

        $I->sendGetRequest('/user/'.$this->requestAddUser['username']);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody([
            "username" => $this->requestAddUser[0]['username'],
            "firstName" => $this->requestAddUser[0]['firstName'],
            "lastName" => $this->requestAddUser[0]['lastName'],
            "email" => $this->requestAddUser[0]['email'],
            "phone" => $this->requestAddUser[0]['phone']
        ]);
    }
    public function retrieveNonexistendUser(ApiTester $I){
        $I->wantToTest('Retrieve user successfully');

        $I->addHeaders();

        $I->sendGetRequest('/user/'.$this->nonexistingUser);

        $I->checkResponseUnsuccessfull();

        $I->checkResponseBody(["message" => "User not found"]);
    }

    public function updateUser(ApiTester $I){
        $I->wantToTest('Update user successfully');

        $I->addHeaders();

        $I->sendPutRequest('/user/'.$this->requestAddUser['username'],$this->requestUpdateUser);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody(["code" => 200]);
    }

    public function deleteUser(ApiTester $I, ){
        $I->wantToTest('Delete user successfully');

        $I->addHeaders();

        $I->sendDeleteRequest('/user/'.$this->requestUpdateUser['username']);

        $I->checkResponseSuccessfull();

        $I->checkResponseBody(["code" => 200, "message" => $this->requestUpdateUser['username']]);
    }
}