<?php

return array(

    /*
     * Employer Plans in Snappeejobs
     */
    'employer_plans' => [

        'no_plan' => [
            'id' => 'snappeejobs0',
            'name' => 'Blank',
            'description' => 'This is the default plan when you get signed up',
            'price' => 0,
            'addons' => [
                'job_postings' => [
                    'count' => 0,
                    'label' => 'Job Postings'
                ],
                'staff_members' => [
                    'count' => 0,
                    'label' => 'Staff Members'
                ],
                'chats_accepted' => [
                    'count' => 0,
                    'label' => 'Chats Accepted'
                ],
            ]
        ],

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

    ]

);