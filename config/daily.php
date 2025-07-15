<?php

return [

    // Daily.co Bearer Token
    // https://docs.daily.co/reference#authentication

    'token' => env('DAILY_API_KEY'),

    // Daily.co Domain
    // eg: ekochin.daily.co

    'domain' => env('DAILY_DOMAIN', 'ekochin.daily.co'),

];
