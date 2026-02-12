<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supabase Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for self-hosted Supabase instance
    |
    */

    'url' => env('SUPABASE_URL', 'http://localhost:8000'),
    
    'key' => env('SUPABASE_KEY', ''),
    
    'service_key' => env('SUPABASE_SERVICE_KEY', ''),
    
    'jwt_secret' => env('SUPABASE_JWT_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Auth Settings
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'redirect_url' => env('APP_URL') . '/auth/callback',
        'providers' => [
            'google' => [
                'enabled' => true,
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Settings (Future use)
    |--------------------------------------------------------------------------
    */

    'storage' => [
        'bucket' => 'form-uploads',
        'max_file_size' => env('MAX_UPLOAD_SIZE', 10485760), // 10MB
        'allowed_types' => explode(',', env('ALLOWED_FILE_TYPES', 'pdf,doc,docx,jpg,jpeg,png,gif')),
    ],

];
