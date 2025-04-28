<?php

declare(strict_types=1);

namespace Tests\Support\Page\Api;

class HeaderParameters
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var \Tests\Support\ApiTester;
     */

    public function __construct()
    {
        // you can inject other page objects here as well
    }

    public function returnHeadersParam(){
        return [
            'acceptHeader' => 'application/json',
        ];
    }

}
