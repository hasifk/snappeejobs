<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'thumbnails' => [
        'user_profile_image' => [
            [
                'height' => 90,
                'width'  => 90,
            ],
            [
                'height' => 39,
                'width'  => 39,
            ],
            [
                'height' => 45,
                'width'  => 45,
            ],
            [
                'height' => 25,
                'width'  => 25,
            ]
        ],

        'company_people' => [
            [
                'height' => 90,
                'width'  => 90,
            ],
            [
                'height' => 45,
                'width'  => 45,
            ],
            [
                'height' => 25,
                'width'  => 25,
            ]
        ],

        'company_photo' => [
            [
                'height' => 218,
                'width'  => 295,
            ],
            [
                'height' => 90,
                'width'  => 90,
            ],
            [
                'height' => 45,
                'width'  => 45,
            ],
            [
                'height' => 25,
                'width'  => 25,
            ]
        ],

        'company_logo' => [
            [
                'height' => 90,
                'width'  => 90,
            ],
            [
                'height' => 45,
                'width'  => 45,
            ],
            [
                'height' => 25,
                'width'  => 25,
            ]
        ],

        'jobseeker_images' => [
            [
                'height' => 90,
                'width'  => 90,
            ],
            [
                'height' => 45,
                'width'  => 45,
            ],
            [
                'height' => 25,
                'width'  => 25,
            ]
        ]

    ]

);
