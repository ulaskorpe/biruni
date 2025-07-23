<?php

return [

    'app_name' => env('APP_NAME'),
    'app_url' => env('APP_URL'),
    'google_cid' => env('GOOGLE_CID'),
    'google_api_key' => env('GOOGLE_API_KEY'),
    'google_api_key_be' => env('GOOGLE_API_KEY_BE'),
    'app_conversion_media_format' => env('APP_CONVERSION_MEDIA_FORMAT','webp'),
    'app_media_resize_rule' => env('APP_MEDIA_RESIZE_RULE','skip'), //kucuk gorseller gerektiginde resize icin skip, padding eklemek icin padding

];