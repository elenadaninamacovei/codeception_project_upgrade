<?php

declare(strict_types=1);

namespace Tests\Support\Page\Api;

class SetHeaders
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

    public static $responseType = 'application/json';

    public function __construct(\Tests\Support\ApiTester $I)
    {
        $this->apiTester = $I;
        // you can inject other page objects here as well
    }

    public function addHeaders(){
        $I = $this->apiTester;

        $I->amGoingTo('Send request headers');
        $I->haveHttpHeader('accept', self::$responseType);
        $I->haveHttpHeader('Content-Type', self::$responseType);
    }

}
