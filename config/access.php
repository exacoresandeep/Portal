<?php

$commonMenus = [

    'dashboard',
    'employee-management',
    'payslip',
    'time-attendance',
    "calender-schedule",
    'attendance-tracking',
    'attendance-regularization',
    'attendance-summary',

    'leave-management',
    'leave-request',
    'wfh-request',

     'expense-management',

    'project-management',
    // 'all-projects',
    'tasks-allocation',
    'my-tasks',
    

];
$adminMenus = array_merge($commonMenus, [

    'dashboard',
    'employee-management',
    'employee-onboard',
    'employees',
    'employee-offboard',
    'payroll',
    'payslip',

    'asset-management',
    'assets-requests',
    'assigned-assets',

    'time-attendance',
    'attendance-capture',
    'calender-schedule',
    'attendance-tracking',
    'attendance-regularization',
    'attendance-summary',

    'leave-management',
    'leave-request',
    'wfh-request',
    'leave-count',

    'expense-management',

    'project-management',
    'all-projects',
    'tasks-allocation',
    'my-tasks',
    'tasks-utilization',

    'performance-tracking',
    'evaluation-forms',
    'evaluation-scheduling',
    'evaluation-report',
    'pip',

    'learning-developing',
    'training-phase',
    'training-assign',

]);
return [

    'page' => [

        // 1 => [

        //     'dashboard',

        //     'employee-management',
        //     'employee-onboard',
        //     'employees',
        //     'employee-offboard',
        //     'payroll',
        //     'payslip',

        //     'asset-management',
        //     'assets-requests',
        //     'assigned-assets',

        //     'time-attendance',
        //     'attendance-capture',
        //     'calender-schedule',
        //     'attendance-tracking',
        //     'attendance-regularization',
        //     'attendance-summary',

        //     'leave-management',
        //     'leave-request',
        //     'wfh-request',
        //     'leave-count',

        //     'expense-management',

        //     'project-management',
        //     'all-projects',
        //     'tasks-allocation',
        //     'my-tasks',
        //     'tasks-utilization',

        //     'performance-tracking',
        //     'evaluation-forms',
        //     'evaluation-scheduling',
        //     'evaluation-report',
        //     'pip',

        //     'learning-developing',
        //     'training-phase',
        //     'training-assign',

        // ],

        // Super Admin
        1 => $adminMenus,

        // HR Admin
        2 => $adminMenus,

        // Project Manager
        3 => array_merge($commonMenus, [

            'project-management',
            'all-projects',
            'tasks-allocation',
            'my-tasks',
            'tasks-utilization',

        ]),

        // Employee
        4 => $commonMenus,
        5 => $commonMenus,
        6 => array_merge($commonMenus, [

            'all-projects',

        ]),
        
        7 => $commonMenus,
        8 => $commonMenus,

        // Attendance Manager
        9 => array_merge($commonMenus, [

            'time-attendance',
            'attendance-regularization',
            'attendance-summary',

        ]),

        // Others
        10 => $commonMenus,
        11 => $commonMenus,

    ],


];