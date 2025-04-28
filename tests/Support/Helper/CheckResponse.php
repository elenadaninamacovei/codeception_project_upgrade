<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class CheckResponse extends \Codeception\Module
{
    public function checkResponseSuccessfull(){
        $rest = $this->getModule('REST');

        $rest->debug('Check response');
        $rest->seeResponseCodeIsSuccessful();
        $rest->seeResponseIsJson();
    }

    public function checkResponseUnsuccessfull(){
        $rest = $this->getModule('REST');

        $rest->debug('Check response');
        $rest->seeResponseCodeIs(404);
    }

    public function checkResponseBody(array $responseArray){
        $rest = $this->getModule('REST');

        $rest->debug('Check response body');
        $rest->seeResponseContainsJson($responseArray);
    }

}
