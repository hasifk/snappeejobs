<?php

return array(

    /*
     * Employer Plans in Snappeejobs
     */
    'employer_plans' => [

        'no_plan' => [
            'id' => 'snappeejobs0',
            'name' => 'Blank',
            'price' => 0,
            'addons' => [
                'job_postings' => 0,
                'staff_members' => 0,
                'chats_accepted' => 0,
            ]
        ],

        'plan_1' => [
            'id' => 'snappeejobs1',
            'name' => 'Startup',
            'price' => 10000,
            'addons' => [
                'job_postings' => 10,
                'staff_members' => 10,
                'chats_accepted' => 10,
            ]
        ],

        'plan_2' => [
            'id' => 'snappeejobs2',
            'name' => 'Growth',
            'price' => 50000,
            'addons' => [
                'job_postings' => 50,
                'staff_members' => 50,
                'chats_accepted' => 50,
            ]
        ],

        'plan_3' => [
            'id' => 'snappeejobs3',
            'name' => 'Professional',
            'price' => 200000,
            'addons' => [
                'job_postings' => 200,
                'staff_members' => 200,
                'chats_accepted' => 200,
            ]
        ],

    ]

);