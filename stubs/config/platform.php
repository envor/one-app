<?php

return [
    'landing_page_disk' => env('LANDING_PAGE_DISK', 'public'),
    'profile_photo_disk' => env('PROFILE_PHOTO_DISK', 'public'),
    'stores_contact_info' => env('STORES_CONTACT_INFO', true),
    'empty_logo_path' => 'profile-photos/no_image.jpg',
    'empty_phone' => '(_ _ _) _ _ _- _ _ _ _',
    'empty_fax' => '(_ _ _) _ _ _- _ _ _ _',
    'logo_path' => env('PLATFORM_LOGO_PATH'), //resource_path('legacy/qwoffice/print/DigLogo.jpg'
    'name' => env('PLATFORM_NAME'),
    'phone' => env('PLATFORM_PHONE_NUMBER'),
    'fax' => env('PLATFORM_FAX_NUMBER'),
    'street_address' => env('PLATFORM_STREET_ADDRESS'),
    'city_state_zip' => env('PLATFORM_CITY_STATE_ZIP'),
    'email' => env('PLATFORM_EMAIL'),
];
