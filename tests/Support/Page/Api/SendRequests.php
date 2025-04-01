<?php

declare(strict_types=1);

namespace Tests\Support\Page\Api;

class SendRequests
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var \Tests\Support\ApiTester;
     */
    protected $apiTester;

    public function __construct(\Tests\Support\ApiTester $I)
    {
        $this->apiTester = $I;
        // you can inject other page objects here as well
    }

    public function sendPostRequest(string $urlPath, $requestData){
        $I = $this->apiTester;

        $I->amGoingTo('Send request');
        $I->sendPost($urlPath, json_encode($requestData));
    }

    public function sendGetRequest(string $urlPath){
        $I = $this->apiTester;

        $I->amGoingTo('Send request');
        $I->sendGet($urlPath);
    }

    public function sendDeleteRequest(string $urlPath){
        $I = $this->apiTester;

        $I->amGoingTo('Send request');
        $I->sendDelete($urlPath);
    }

    public function sendPutRequest(string $urlPath, $requestData){
        $I = $this->apiTester;

        $I->amGoingTo('Send request');
        $I->sendPut($urlPath, json_encode($requestData));
    }

}
