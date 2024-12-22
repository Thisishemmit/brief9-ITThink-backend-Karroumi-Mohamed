<?php

return [
    'admin' => [
        '/admin/users' =>  [
            'name' => 'Users Management',
            'icon' => 'group',
            'path' => 'app/controllers/admin/users.php',
            'roles' => ['admin']
        ],
        '/admin/projects' => [
            'name' => 'Projects',
            'icon' => 'work',
            'path' => 'app/controllers/admin/projects.php',
            'roles' => ['admin']
        ],
        '/admin/categories' => [
            'name' => 'Categories',
            'icon' => 'category',
            'path' => 'app/controllers/admin/categories.php',
            'roles' => ['admin']
        ],
        '/admin/offers' => [
            'name' => 'Offers',
            'icon' => 'description',
            'path' => 'app/controllers/admin/offers.php',
            'roles' => ['admin']
        ],
        '/admin/testimonials' => [
            'name' => 'Testimonials',
            'icon' => 'rate_review',
            'path' => 'app/controllers/admin/testimonials.php',
            'roles' => ['admin']
        ],
        '/admin/statistics' => [
            'name' => 'Statistics',
            'icon' => 'analytics',
            'path' => 'app/controllers/admin/statistics.php',
            'roles' => ['admin']

        ]
    ],

    'client' => [
        '/client/projects' => [
            'name' => 'My Projects',
            'icon' => 'work',
            'path' => 'app/controllers/client/projects.php',
            'roles' => ['client']
        ],
        '/client/offers' => [
            'name' => 'Received Offers',
            'icon' => 'description',
            'path' => 'app/controllers/client/offers.php',
            'roles' => ['client']
        ],
        '/client/testimonials' => [
            'name' => 'My Testimonials',
            'icon' => 'rate_review',
            'path' => 'app/controllers/client/testimonials.php',
            'roles' => ['client']
        ],

    ],

    'freelancer' => [
        '/freelancer/projects' => [
            'name' => 'Available Projects',
            'icon' => 'work_outline',
            'path' => 'app/controllers/freelancer/projects.php',
            'roles' => ['freelancer']
        ],
        '/freelancer/offers' => [
            'name' => 'My Offers',
            'icon' => 'description',
            'path' => 'app/controllers/freelancer/offers.php',
            'roles' => ['freelancer']
        ],
        '/freelancer/skills' => [
            'name' => 'My Skills',
            'icon' => 'psychology',
            'path' => 'app/controllers/freelancer/skills.php',
            'roles' => ['freelancer']
        ],
        '/freelancer/history' => [
            'name' => 'Work History',
            'icon' => 'history',
            'path' => 'app/controllers/freelancer/history.php',
            'roles' => ['freelancer']
        ],
        '/freelancer/reviews' => [
            'name' => 'Client Reviews',
            'icon' => 'star_rate',
            'path' => 'app/controllers/freelancer/reviews.php',
            'roles' => ['freelancer']
        ]
    ],

    'all' => [
        '/' => [
            'name' => 'Dashboard',
            'icon' => 'dashboard',
            'path' => 'app/controllers/index.php',
            'roles' => ['admin', 'freelancer', 'client']
        ],
    ]
];
