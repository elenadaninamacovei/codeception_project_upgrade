<?php

namespace Tests\Support\Page\Api;

class Routes
{
    public static function route(string $format, ...$params): string
    {
        return sprintf($format, ...$params);
    }

    const PET = '/pet';
    const FIND_BY_STATUS = '/pet/findByStatus';
}
