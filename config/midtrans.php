<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false) ? 
                  'https://app.midtrans.com/snap/v2/vtweb/' : 
                  'https://app.sandbox.midtrans.com/snap/v2/vtweb/',
    'api_url' => env('MIDTRANS_IS_PRODUCTION', false) ? 
                  'https://api.midtrans.com' : 
                  'https://api.sandbox.midtrans.com',
];