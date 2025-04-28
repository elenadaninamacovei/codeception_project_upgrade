<?php

declare(strict_types=1);

namespace Tests\Support\Helper;


// here you can define custom actions
// all public methods declared in helper class will be available in $I

class SendRequests extends \Codeception\Module
{
    public function sendPostRequest(string $urlPath, $requestData){
        $rest = $this->getModule('REST');

        $this->debug('Send request');
        $rest->sendPost($urlPath, json_encode($requestData));
    }

    public function sendGetRequest(string $urlPath){
        $rest = $this->getModule('REST');

        $this->debug('Send request');
        $rest->sendGet($urlPath);
    }

    public function sendDeleteRequest(string $urlPath){
        $rest = $this->getModule('REST');

        $this->debug('Send request');
        $rest->sendDelete($urlPath);
    }

    public function sendPutRequest(string $urlPath, $requestData){
        $rest = $this->getModule('REST');
        
        $this->debug('Send request');
        $rest->sendPut($urlPath, json_encode($requestData));
    }
}
