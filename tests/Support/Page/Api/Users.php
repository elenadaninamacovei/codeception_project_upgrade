<?php

declare(strict_types=1);

namespace Tests\Support\Page\Api;

class Users
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

    public function checkResponseSuccessfull(){
        $I = $this->apiTester;

        $I->amGoingTo('Check response');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function checkResponseUnsuccessfull(){
        $I = $this->apiTester;

        $I->amGoingTo('Check response');
        $I->seeResponseCodeIs(404);
    }

    public function checkResonseBody(array $responseArray){
        $I = $this->apiTester;

        $I->amGoingTo('Check response body');
        $I->seeResponseContainsJson($responseArray);
    }

    


}
