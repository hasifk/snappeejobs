<?php

return array(

    /*
     * Employer Plans in Snappeejobs
     */
    'employer_plans' => [

        'plan_1' => [
            'id' => 'snappeejobs1',
            'name' => 'Startup',
            'description' => 'Startup Plan, choose this plan if your company is small',
            'price' => 10000,
            'addons' => [
                'job_postings' => [
                    'count' => 10,
                    'label' => 'Job Postings'
                ],
                'staff_members' => [
                    'count' => 10,
                    'label' => 'Staff Members'
                ],
                'chats_accepted' => [
                    'count' => 10,
                    'label' => 'Chats Accepted'
                ],
            ]
        ],

        'plan_2' => [
            'id' => 'snappeejobs2',
            'name' => 'Growth',
            'description' => 'Medium Plan, choose this plan if your company is medium',
            'price' => 50000,
            'addons' => [
                'job_postings' => [
                    'count' => 50,
                    'label' => 'Job Postings'
                ],
                'staff_members' => [
                    'count' => 50,
                    'label' => 'Staff Members'
                ],
                'chats_accepted' => [
                    'count' => 50,
                    'label' => 'Chats Accepted'
                ],
            ]
        ],

        'plan_3' => [
            'id' => 'snappeejobs3',
            'name' => 'Professional',
            'description' => 'Professinal Plan, choose this plan if your company is big',
            'price' => 200000,
            'addons' => [
                'job_postings' => [
                    'count' => 200,
                    'label' => 'Job Postings'
                ],
                'staff_members' => [
                    'count' => 200,
                    'label' => 'Staff Members'
                ],
                'chats_accepted' => [
                    'count' => 200,
                    'label' => 'Chats Accepted'
                ],
            ]
        ],

    ],

    'addons_packs' => [
        'pack1' => [
            'label'                 => 'Pack 1',
            'job_postings'          => 2,
            'staff_members'         => 1,
            'chats_accepted'        => 4,
            'price'                 => 5
        ],
        'pack2' => [
            'label'                 => 'Pack 2',
            'job_postings'          => 4,
            'staff_members'         => 2,
            'chats_accepted'        => 8,
            'price'                 => 10
        ],
        'pack3' => [
            'label'                 => 'Pack 3',
            'job_postings'          => 6,
            'staff_members'         => 3,
            'chats_accepted'        => 10,
            'price'                 => 15
        ],
    ],

    'addon_prices' => [
        'job_postings'          => 1,
        'staff_members'         => 2,
        'chats_accepted'        => 1
    ],
      'job_makepaid' => [
      'price'        => 2,
     'time_frame'          =>604800

],
    'company_makepaid' => [
        'price'        => 5,
        'time_frame'          =>604800

    ]
);
