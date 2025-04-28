<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Tests\Support\Page\Api\HeaderParameters;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class SetHeaders extends \Codeception\Module
{
    public function addHeaders(){
        $rest = $this->getModule('REST');

        $page = new HeaderParameters(); // Or use dependency injection if needed
        $headers = $page->returnHeadersParam();

        $rest->debug('Send request headers');
        $rest->haveHttpHeader('accept', $headers['acceptHeader']);
        $rest->haveHttpHeader('Content-Type', $headers['acceptHeader']);
    }
    
}
