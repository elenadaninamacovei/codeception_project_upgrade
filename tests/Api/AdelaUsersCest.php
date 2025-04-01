<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use \Tests\Support\Page\Api\Users;
use \Tests\Support\Page\Api\SendRequests;
use \Tests\Support\Page\Api\SetHeaders;

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
    }

    public function addNewUserSuccessfully(ApiTester $I, Users $user, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Create user successfully');

        $setHeader->addHeaders();

        $sendRequest->sendPostRequest('/user/createWithList', $this->requestAddUser);

        $user->checkResponseSuccessfull();

        $user->checkResonseBody(["code" => 200, "message" => "ok"]);
    }

    public function retrieveUser(ApiTester $I, Users $user, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Retrieve user successfully');

        $setHeader->addHeaders();

        $sendRequest->sendGetRequest('/user/BoldeanuAdela');

        $user->checkResponseSuccessfull();

        $user->checkResonseBody([
            "username" => $this->requestAddUser[0]['username'],
            "firstName" => $this->requestAddUser[0]['firstName'],
            "lastName" => $this->requestAddUser[0]['lastName'],
            "email" => $this->requestAddUser[0]['email'],
            "phone" => $this->requestAddUser[0]['phone']
        ]);
    }
    public function retrieveNonexistendUser(ApiTester $I, Users $user, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Retrieve user successfully');

        $setHeader->addHeaders();

        $sendRequest->sendGetRequest('/user/testBoldeanuAdelaTest');

        $user->checkResponseUnsuccessfull();

        $user->checkResonseBody(["message" => "User not found"]);
    }

    public function updateUser(ApiTester $I, Users $user, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Update user successfully');

        $setHeader->addHeaders();

        $sendRequest->sendPutRequest('/user/BoldeanuAdela',$this->requestUpdateUser);

        $user->checkResponseSuccessfull();

        $user->checkResonseBody(["code" => 200]);
    }

    public function deleteUser(ApiTester $I, Users $user, SendRequests $sendRequest, SetHeaders $setHeader){
        $I->wantToTest('Delete user successfully');

        $setHeader->addHeaders();

        $sendRequest->sendDeleteRequest('/user/BoldeanuAdelaUpdate');

        $user->checkResponseSuccessfull();

        $user->checkResonseBody(["code" => 200, "message" => $this->requestUpdateUser['username']]);
    }
}