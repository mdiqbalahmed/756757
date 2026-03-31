<?php

namespace Croogo\Core\Config;

use Croogo\Core\Nav;

Nav::add('sidebar', 'Gallery', [
    'icon' => 'camera',
    'title' => __d('gallery', 'Gallery'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Album',
        'action' => 'viewAlbum',
    ],
    'weight' => 70,
    'children' => [
        'ListofAlbums' => [ // students is a example but there must be different name for different menu
            'title' => __d('gallery', 'List of Albums'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Album',
                'action' => 'viewAlbum',
            ],
            'weight' => 10,
        ],
        'List of Photos' => [
            'title' => __d('gallery', 'List of Photos'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Photos',
                'action' => 'viewPhotos',
            ],
            'weight' => 100,
        ],
    ],
]);

Nav::add('sidebar', 'CMS', [
    'icon' => 'desktop',
    'title' => __d('boxes', 'CMS'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Cms',
        'action' => 'boxes',
    ],
    'weight' => 80,
    'children' => [
        'ListofBoxes' => [
            'title' => __d('boxes', 'List of Boxes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Cms',
                'action' => 'Boxes',
            ],
            'weight' => 10,
        ],
        'ListofConfigs' => [
            'title' => __d('boxes', 'List of Configs'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Cms',
                'action' => 'pageConfig',
            ],
            'weight' => 101,
        ],
        'QuickLink' => [
            'title' => __d('boxes', 'Quick Links'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Cms',
                'action' => 'quickLink',
            ],
            'weight' => 111,
        ],
    ],
]);

Nav::add('sidebar', 'Setup', [
    'icon' => 'cogs',
    'title' => __d('Setup', 'Setup'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Setup',
        'action' => 'index',
    ],
    'weight' => 90,
    'children' => [
        'Facuties' => [
            'title' => __d('Setup', 'Facuties'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'faculty',
            ],
            'weight' => 10,
        ],
        'Department' => [
            'title' => __d('Setup', 'Department'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'department',
            ],
            'weight' => 20,
        ],
        'Classes' => [
            'title' => __d('Setup', 'Classes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'level',
            ],
            'weight' => 30,
        ],
        'Sections' => [
            'title' => __d('Setup', 'Sections'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'section',
            ],
            'weight' => 40,
        ],
        'Sessions' => [
            'title' => __d('Setup', 'Sessions'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'session',
            ],
            'weight' => 50,
        ],
        'Shifts' => [
            'title' => __d('Setup', 'Shifts'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'shift',
            ],
            'weight' => 60,
        ],
        'Courses & Terms' => [
            'title' => __d('menu', 'Courses & Terms'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'index',
            ],
            'weight' => 80,
            'children' => [
                'Course' => [
                    'title' => __d('menu', 'Course'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'course',
                    ],
                    'weight' => 10,
                    'children' => [
                        'Course' => [
                            'title' => __d('menu', 'Course'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Setup',
                                'action' => 'course',
                            ],
                            'weight' => 10,
                        ],
                        'Courses Cycle' => [
                            'title' => __d('menu', 'Courses Cycle'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Setup',
                                'action' => 'coursesCycle',
                            ],
                            'weight' => 20,
                        ],
                    ],
                ],
                'Activity' => [
                    'title' => __d('menu', 'Activity'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'activity',
                    ],
                    'weight' => 20,
                    'children' => [
                        'Activity' => [
                            'title' => __d('menu', 'Activity'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Setup',
                                'action' => 'activity',
                            ],
                            'weight' => 30,
                        ],
                        'Activity Cycle' => [
                            'title' => __d('menu', 'Activity Cycle'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Setup',
                                'action' => 'activityCycle',
                            ],
                            'weight' => 40,
                        ],
                    ],
                ],
                'Terms' => [
                    'title' => __d('menu', 'Terms'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'term',
                    ],
                    'weight' => 20,
                    'children' => [
                        'Terms' => [
                            'title' => __d('menu', 'Terms'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Setup',
                                'action' => 'term',
                            ],
                            'weight' => 50,
                        ],
                        'Term Cycle' => [
                            'title' => __d('menu', 'Term Cycle'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Setup',
                                'action' => 'termCycle',
                            ],
                            'weight' => 60,
                        ],
                    ],
                ],
                'Part Distribution' => [
                    'title' => __d('menu', 'Part Distribution'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'marksDistribution',
                    ],
                    'weight' => 70,
                ],
                'Term Courses List' => [
                    'title' => __d('menu', 'Term Courses List'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'termCoursesList',
                    ],
                    'weight' => 80,
                ],
            ],
        ],
        'Promotion' => [
            'title' => __d('menu', 'Promotion'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
            ],
            'weight' => 90,
            'children' => [
                'Course Cycle' => [
                    'title' => __d('menu', 'Course Cycle'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'courseCyclePromotion',
                    ],
                    'weight' => 10,
                ],
                'Activity Cycle' => [
                    'title' => __d('menu', 'Activity Cycle'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'activityCyclePromotion',
                    ],
                    'weight' => 20,
                ],
                'Term Cycle' => [
                    'title' => __d('menu', 'Term Cycle'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'termCyclePromotion',
                    ],
                    'weight' => 30,
                ],
            ],
        ],
        'Gradings' => [
            'title' => __d('menu', 'Gradings'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Gradings',
                'action' => 'index',
            ],
            'weight' => 100,
        ],
        'SMS Credit' => [
            'title' => __d('menu', 'SMS Credit'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'renew',
            ],
            'weight' => 90,
            'children' => [
                'SMS Credit' => [
                    'title' => __d('menu', 'SMS Credit'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'renew',
                    ],
                    'weight' => 10,
                ],
                'SMS Credit Log' => [
                    'title' => __d('menu', 'SMS Credit Log'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Setup',
                        'action' => 'renewReport',
                    ],
                    'weight' => 30,
                ],
            ],
        ],
    ],
]);

Nav::add('sidebar', 'SMS Panel', [
    'icon' => 'envelope',
    'title' => __d('menu', 'SMS Panel'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Sms',
        'action' => 'index',
    ],
    'weight' => 100,
    'children' => [
        'General SMS' => [
            'title' => __d('menu', 'General SMS'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Sms',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'SMS Logs' => [
            'title' => __d('menu', 'SMS Logs'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Sms',
                'action' => 'smsLogs',
            ],
            'weight' => 20,
        ],
        'SMS Permission' => [
            'title' => __d('menu', 'SMS Permission'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'sms',
                'action' => 'smsPermission',
            ],
            'weight' => 30,
        ],
        'Other Sms' => [
            'title' => __d('menu', 'Other Sms'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'sms',
                'action' => 'otherSms',
            ],
            'weight' => 40,
        ],
    ],
]);

Nav::add('sidebar', 'Students', [
    'icon' => 'address-book',
    'title' => __d('menu', 'Students'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Students',
        'action' => 'index',
    ],
    'weight' => 110,
    'children' => [
        'students' => [ // students is a example but there must be different name for different menu
            'title' => __d('menu', 'Students'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'add' => [
            'title' => __d('menu', 'Add a Student'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'add',
            ],
            'weight' => 20,
        ],
        'Add Mark' => [
            'title' => __d('menu', 'Add Mark'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'addResult',
            ],
            'weight' => 30,
            'children' => [
                'Add Mark' => [
                    'title' => __d('menu', 'Add Mark'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'addResult',
                    ],
                    'weight' => 10,
                ],
                'Add Quiz Mark' => [
                    'title' => __d('menu', 'Add Quiz Mark'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'addQuizResult',
                    ],
                    'weight' => 20,
                ],
                'Add Activity' => [
                    'title' => __d('menu', 'Add Activity'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'addActivityResult',
                    ],
                    'weight' => 30,
                ],
                'Mark Entry Report' => [
                    'title' => __d('menu', 'Mark Entry Report'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'markEntryReport',
                    ],
                    'weight' => 40,
                ],
            ],
        ],
        'Promotion' => [
            'title' => __d('menu', 'Promotion'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'individualPromotion',
            ],
            'weight' => 60,
            'children' => [
                'Promotion' => [
                    'title' => __d('menu', 'Promotion'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'promotion',
                    ],
                    'weight' => 10,
                ],
                'Promotion Template' => [
                    'title' => __d('menu', 'Promotion Template'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'promotionTemplate',
                    ],
                    'weight' => 20,
                ],
                'Individual Promotion' => [
                    'title' => __d('menu', 'Individual Promotion'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'individualPromotion',
                    ],
                    'weight' => 30,
                ],
                'Update Roll' => [
                    'title' => __d('menu', 'Update Roll'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'customRoll',
                    ],
                    'weight' => 40,
                ],
                'Promotion Log' => [
                    'title' => __d('menu', 'Promotion Log'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'promotionLog',
                    ],
                    'weight' => 50,
                ],
                'Promotion List' => [
                    'title' => __d('menu', 'Promotion List'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'promotionList',
                    ],
                    'weight' => 60,
                ],
            ],
        ],
        'Temp Student\'s List' => [
            'title' => __d('menu', 'Temp Student\'s List'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'tindex',
            ],
            'weight' => 70,
        ],
        'Admission' => [
            'title' => __d('menu', 'Admission'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'admissionRoom',
            ],
            'weight' => 80,
            'children' => [
                'Admission Room' => [
                    'title' => __d('menu', 'Admission Room'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'admissionRoom',
                    ],
                    'weight' => 10,
                ],
                'Seat Plan' => [
                    'title' => __d('menu', 'Admission Seat Plan'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'seatplan',
                    ],
                    'weight' => 20,
                ],
                'View Seat Plan' => [
                    'title' => __d('menu', 'Admission View Seat Plan'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'viewSeatplan',
                    ],
                    'weight' => 30,
                ],
            ],
        ],
        'Tution Fees' => [
            'title' => __d('menu', 'Tution Fees'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'tutionFees',
            ],
            'weight' => 110,
        ],
        'Data Settings' => [
            'title' => __d('menu', 'Data Settings'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'dataSettings',
            ],
            'weight' => 120,
            'children' => [
                'Student\'s data Settings' => [
                    'title' => __d('menu', 'Student\'s Fields'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'dataSettings',
                    ],
                    'weight' => 10,
                ],
                'Student\'s datas' => [
                    'title' => __d('menu', 'Student\'s All Blocks'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'datas',
                    ],
                    'weight' => 20,
                ],
            ],
        ],
        'Image Download' => [
            'title' => __d('menu', 'Student Image Download'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'imageDownload',
            ],
            'weight' => 150,
        ],
        'Upload Students' => [
            'title' => __d('menu', 'Upload Students'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'upload',
            ],
            'weight' => 160,
            'children' => [
                'Upload Students' => [
                    'title' => __d('menu', 'Upload Students'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'upload',
                    ],
                    'weight' => 10,
                ],
                'Upload Students Image' => [
                    'title' => __d('menu', 'Upload Students Image'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'uploadImage',
                    ],
                    'weight' => 20,
                ],
            ],
        ],
        'Student Logs' => [
            'title' => __d('menu', 'Student Logs'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'activeStatus',
            ],
            'weight' => 170,
        ],
        'Student Cycle' => [
            'title' => __d('menu', 'Student Cycle'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'refactorCycle',
            ],
            'weight' => 170,
            'children' => [
                'Refactor Cycle' => [
                    'title' => __d('menu', 'Refactor Cycle'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'refactorCycle',
                    ],
                    'weight' => 10,
                ],
                'View Cycle' => [
                    'title' => __d('menu', 'View Cycle'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'viewCycle',
                    ],
                    'weight' => 20,
                ],
                'Individual Term' => [
                    'title' => __d('menu', 'Individual Term Assign'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Students',
                        'action' => 'individualTermAssign',
                    ],
                    'weight' => 30,
                ],
            ],
        ],
    ],
]);

Nav::add('sidebar', 'Attendance', [
    'icon' => 'calendar-check',
    'title' => __d('menu', 'Attendance'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Attendance',
        'action' => 'index',
    ],
    'weight' => 120,
    'children' => [
        'Attendance' => [
            'title' => __d('menu', 'Attendance'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Attendance',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'Device Attendence' => [
            'title' => __d('menu', 'Device Attendence'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Attendance',
                'action' => 'deviceAttendence',
            ],
            'weight' => 20,
        ],
        'Device Log' => [
            'title' => __d('menu', 'Device Log'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Attendance',
                'action' => 'deviceLog',
            ],
            'weight' => 30,
        ],
        'Attendance Sheet' => [
            'title' => __d('menu', 'Attendance Sheet'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Attendance',
                'action' => 'attendanceSheet',
            ],
            'weight' => 40,
        ],
        'Class Wise Attendance Report' => [
            'title' => __d('menu', 'Class Wise Attendance Report'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Attendance',
                'action' => 'atdReport',
            ],
            'weight' => 50,
        ],
        'Monthly Attendance Report' => [
            'title' => __d('menu', 'Monthly Attendance Report'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Attendance',
                'action' => 'monthlyAttendenceReport',
            ],
            'weight' => 60,
        ]
    ],
]);

Nav::add('sidebar', 'Result', [
    'icon' => 'list-ol',
    'title' => __d('menu', 'Result'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Results',
        'action' => 'index',
    ],
    'weight' => 130,
    'children' => [
        'Result' => [
            'title' => __d('menu', 'Result'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Results',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'View Result' => [
            'title' => __d('menu', 'View Result'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Results',
                'action' => 'viewResult',
            ],
            'weight' => 20,
        ],
        'Merge Result' => [
            'title' => __d('menu', 'Merge Result'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Results',
                'action' => 'mergeResult',
            ],
            'weight' => 30,
        ],
        'View Merge Result' => [
            'title' => __d('menu', 'View Merge Result'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Results',
                'action' => 'viewMergeResult',
            ],
            'weight' => 40,
        ],
        'Result Template' => [
            'title' => __d('menu', 'Result Template'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Results',
                'action' => 'indexTemplate',
            ],
            'weight' => 50,
        ],
        'Number Fordo' => [
            'title' => __d('menu', 'Number Fordo'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'numberFordo',
            ],
            'weight' => 60,
        ],
    ],
]);

Nav::add('sidebar', 'Accounts', [
    'icon' => 'university',
    'title' => __d('menu', 'Accounts'),
    'weight' => 140,
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Accounts',
        'action' => 'index',
    ],
    'children' => [
        'Bank' => [
            'title' => __d('menu', 'Bank'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'banks',
            ],
            'weight' => 10,
        ],
        'Purposes' => [
            'title' => __d('menu', 'Purposes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'purposes',
            ],
            'weight' => 20,
        ],
        'Transactions' => [
            'title' => __d('menu', 'Transactions'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'debitList',
            ],
            'weight' => 30,
            'children' => [
                'Debit' => [
                    'title' => __d('menu', 'Debit'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'debitList',
                    ],
                    'weight' => 10,
                    'children' => [
                        'addDebit' => [
                            'title' => __d('menu', 'Add Debit'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Accounts',
                                'action' => 'addDebit',
                            ],
                            'weight' => 10,
                        ],
                        'List of Debit' => [
                            'title' => __d('menu', 'List of Debit'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Accounts',
                                'action' => 'debitList',
                            ],
                            'weight' => 20,
                        ],
                    ],
                ],
                'Credit' => [
                    'title' => __d('menu', 'Credit'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'creditList',
                    ],
                    'weight' => 20,
                    'children' => [
                        'addCredit' => [
                            'title' => __d('menu', 'Add Credit'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Accounts',
                                'action' => 'addCredit',
                            ],
                            'weight' => 10,
                        ],
                        'addVoucher' => [
                            'title' => __d('menu', 'Add Voucher'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Accounts',
                                'action' => 'addVoucher',
                            ],
                            'weight' => 20,
                        ],
                        'List of Credit' => [
                            'title' => __d('menu', 'List of Credit'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Accounts',
                                'action' => 'creditList',
                            ],
                            'weight' => 30,
                        ],
                        'Unpaid Vouchers' => [
                            'title' => __d('menu', 'Unpaid Vouchers'),
                            'url' => [
                                'prefix' => 'admin',
                                'plugin' => 'Croogo/Core',
                                'controller' => 'Accounts',
                                'action' => 'unpaidVouchers',
                            ],
                            'weight' => 40,
                        ],
                    ],
                ],
            ],
        ],
        'Additional Fees' => [
            'title' => __d('menu', 'Additionals'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'additionalFees',
            ],
            'weight' => 30,
            'children' => [
                'additionalFees' => [
                    'title' => __d('menu', 'Additional Fees'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'additionalFees',
                    ],
                    'weight' => 20,
                ],
                'generateAdditionalFees' => [
                    'title' => __d('menu', 'Generate Fees'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'generateAdditionalFees',
                    ],
                    'weight' => 30,
                ],
                'Individual Fees' => [
                    'title' => __d('menu', 'Individual Fees'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'individualFees',
                    ],
                    'weight' => 40,
                ],
            ],
        ],
        'FeesKhats' => [
            'title' => __d('menu', 'Fees-Khats'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'feesKhatSettings',
            ],
            'weight' => 31,
            'children' => [
                'FeesKhatSettings' => [
                    'title' => __d('menu', 'Fees-Khat Settings'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'feesKhatSettings',
                    ],
                    'weight' => 10,
                ],
                'multipleFeesKhat' => [
                    'title' => __d('menu', 'Multiple Fees-Khat Settings'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'multipleFeesKhat',
                    ],
                    'weight' => 20,
                ],
                'voucher Generate' => [
                    'title' => __d('menu', 'Voucher Generate'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'voucherGenerate',
                    ],
                    'weight' => 30,
                ],
                'Individual Voucher' => [
                    'title' => __d('menu', 'Individual Voucher'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'individualVoucher',
                    ],
                    'weight' => 40,
                ],
            ],
        ],
        'School Fees' => [
            'title' => __d('menu', 'School Fees'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'schoolFees',
            ],
            'weight' => 50,
        ],
        'Report' => [
            'title' => __d('menu', 'Accounts Report'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'index',
            ],
            'weight' => 60,
            'children' => [
                'Transaction Report' => [
                    'title' => __d('menu', 'Transaction Statement'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'transactionStatement',
                    ],
                    'weight' => 10,
                ],
                'Payment Details' => [
                    'title' => __d('menu', 'Payment Details'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'paymentDetails',
                    ],
                    'weight' => 20,
                ],
                'Balance Report' => [
                    'title' => __d('menu', 'Balance Report'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'balanceReport',
                    ],
                    'weight' => 30,
                ],
                'Voucher Statement' => [
                    'title' => __d('menu', 'Voucher Statement'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'voucherStatement',
                    ],
                    'weight' => 40,
                ],
                'Due Report' => [
                    'title' => __d('menu', 'Due Report'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'dueReport',
                    ],
                    'weight' => 50,
                ],
                'Purpose Wise Report' => [
                    'title' => __d('menu', 'Purpose Wise Statement'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'purposeWise',
                    ],
                    'weight' => 60,
                ],
                'Bank Statement Report' => [
                    'title' => __d('menu', 'Bank Statement Statement'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'bankStatementReport',
                    ],
                    'weight' => 70,
                ],
                'ClassWise Fees Report' => [
                    'title' => __d('menu', 'ClassWise Fees Report'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'classwiseFeesCreditReport',
                    ],
                    'weight' => 80,
                ],
            ],
        ],
        'Deleted' => [
            'title' => __d('menu', 'Deleted'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts'
            ],
            'weight' => 70,
            'children' => [
                'Deleted Banks' => [
                    'title' => __d('menu', 'Deleted Banks'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'deletedBanks',
                    ],
                    'weight' => 10,
                ],
                'Deleted Purposes' => [
                    'title' => __d('menu', 'Deleted Purposes'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'deletedPurposes',
                    ],
                    'weight' => 20,
                ],
                'Deleted Transactions' => [
                    'title' => __d('menu', 'Deleted Transactions'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Accounts',
                        'action' => 'deletedTransactions',
                    ],
                    'weight' => 30,
                ],
            ],
        ],
        'Due SMS' => [
            'title' => __d('menu', 'Due SMS'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'dueSms',
            ],
            'weight' => 60,
        ],
        'Two Taka Fund' => [
            'title' => __d('menu', 'Two Taka Fund'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Accounts',
                'action' => 'twoTakafund',
            ],
            'weight' => 70,
        ],
    ],
]);

Nav::add('sidebar', 'Digital Routine', [
    'icon' => 'address-card',
    'title' => __d('admit', 'Digital Routine'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Routine',
        'action' => 'index',
    ],
    'weight' => 145,
    'children' => [
        'Timesheet' => [
            'title' => __d('menu', 'Timesheet'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Routine',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
        'Class Routine' => [
            'title' => __d('menu', 'Class Routine'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Routine',
                'action' => 'classRoutine',
            ],
            'weight' => 20,
        ],
        'Set Routine' => [
            'title' => __d('menu', 'Set Routine'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Routine',
                'action' => 'setRoutine',
            ],
            'weight' => 30,
        ],
        'Shift' => [
            'title' => __d('menu', 'Shift'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Routine',
                'action' => 'Shift',
            ],
            'weight' => 40,
        ],
    ],
]);

Nav::add('sidebar', 'Core HR', [
    'icon' => 'database',
    'title' => __d('menu', 'Core HR'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Hrs',
        'action' => 'index',
    ],
    'weight' => 150,
    'children' => [
        'Shift' => [
            'title' => __d('menu', 'Shift'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'shifts',
            ],
            'weight' => 10,
        ],
        'Roster' => [
            'title' => __d('menu', 'Roster'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'roster',
            ],
            'weight' => 15,
        ],
        'Hr Config' => [
            'title' => __d('menu', 'Hr Config'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'config',
            ],
            'weight' => 20,
        ],
        'Hr Config Setup' => [
            'title' => __d('menu', 'Hr Config Setup'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'configSetup',
            ],
            'weight' => 30,
        ],
        'Employee Attendance' => [
            'title' => __d('menu', 'Employee Attendance'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'attendance',
            ],
            'weight' => 40,
        ],
        'CSV Attendance' => [
            'title' => __d('menu', 'CSV Attendance'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'csvAttendance',
            ],
            'weight' => 45,
        ],
        'Attendance Report' => [
            'title' => __d('menu', 'Attendance Report'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
            ],
            'weight' => 46,
            'children' => [
                'Monthly Report' => [
                    'title' => __d('menu', 'Monthly Report'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Hrs',
                        'action' => 'monthlyAttendanceReport',
                    ],
                    'weight' => 10,
                ],
            ],
        ],
        'Calendar' => [
            'title' => __d('menu', 'Calendar'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'calendar',
            ],
            'weight' => 50,
        ],
        'all_leave' => [
            'title' => __d('menu', 'All Leaves'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'allLeaves',
            ],
            'weight' => 60,
        ],
        'Payroll' => [
            'title' => __d('menu', 'Payroll'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Hrs',
                'action' => 'payroll',
            ],
            'weight' => 70,
        ],
    ],
]);

// Nav::add('sidebar', 'Admit Card', [
//     'icon' => 'address-card',
//     'title' => __d('admit', 'Admit Card'),
//     'url' => [
//         'prefix' => 'admin',
//         'plugin' => 'Croogo/Core',
//         'controller' => 'Admit',
//         'action' => 'index',
//     ],
//     'weight' => 160,
//     'children' => [
//         'Admit Cards' => [
//             'title' => __d('admit', 'List of Admit Cards'),
//             'url' => [
//                 'prefix' => 'admin',
//                 'plugin' => 'Croogo/Core',
//                 'controller' => 'Admit',
//                 'action' => 'index',
//             ],
//             'weight' => 10,
//         ],
//         'Bench Slip' => [
//             'title' => __d('admit', 'Bench Slip'),
//             'url' => [
//                 'prefix' => 'admin',
//                 'plugin' => 'Croogo/Core',
//                 'controller' => 'Admit',
//                 'action' => 'slip',
//             ],
//             'weight' => 100,
//         ],
//     ],
// ]);


Nav::add('sidebar', 'Admit Card', [
    'icon' => 'address-card',
    'title' => __d('admit', 'Admit Card'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Admit',
        'action' => 'index',
    ],
    'weight' => 160,
    'children' => [
        'Set Exam Routine' => [
            'title' => __d('admit', 'Set Exam Routine'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'admitCard',
            ],
            'weight' => 10,
        ],
        'Set Room' => [
            'title' => __d('admit', 'Set Room'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'admitCardStudents',
            ],
            'weight' => 20,
        ],
        'Exam Attendance Sheet' => [
            'title' => __d('admit', 'Exam Attendance Sheet'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'examAttendance',
            ],
            'weight' => 20,
        ],
        'Admit Cards' => [
            'title' => __d('admit', 'List of Admit Cards'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'index',
            ],
            'weight' => 30,
        ],
        'Admitcard Room Delete' => [
            'title' => __d('admit', 'Admitcard Room Delete'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'deleteAdmitCard',
            ],
            'weight' => 40,
        ],
        'Routine Delete' => [
            'title' => __d('admit', 'Routine Delete'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'deleteRoutine',
            ],
            'weight' => 50,
        ],
        'individual AdmitCard' => [
            'title' => __d('admit', 'individual AdmitCard'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'individualAdmitCard',
            ],
            'weight' => 60,
        ],
        'Bench Slip' => [
            'title' => __d('admit', 'Bench Slip'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'slip',
            ],
            'weight' => 70,
        ],
    ],
]);

Nav::add('sidebar', 'Hostel Management', [
    'icon' => 'address-card',
    'title' => __d('hostel', 'Hostel Management'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Buildings',
        'action' => 'index',
    ],
    'weight' => 50,
    'children' => [
        'Hostel' => [
            'title' => __d('hostel', 'Add Hostel'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Buildings',
                'action' => 'addHostel',
            ],
            'weight' => 40,
            'children' => [
                'Add Hostel' => [
                    'title' => __d('menu', 'Add Hostel'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Buildings',
                        'action' => 'addHostel',
                    ],
                    'weight' => 10,
                ],
                'List Of Hostel' => [
                    'title' => __d('menu', 'List Of Hostel'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Buildings',
                        'action' => 'hostels',
                    ],
                    'weight' => 10,
                ]


            ],
        ],
        'Buildings' => [
            'title' => __d('hostel', 'Add Building'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Buildings',
                'action' => 'addBuilding',
            ],
            'weight' => 60,
            'children' => [
                'List of Buildings' => [
                    'title' => __d('menu', 'List of Buildings'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Buildings',
                        'action' => 'index',
                    ],
                    'weight' => 10,
                ],
                'Building Wise Student Report' => [
                    'title' => __d('menu', 'Building Wise Student Report'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Buildings',
                        'action' => 'report',
                    ],
                    'weight' => 10,
                ]
            ],
        ],
        'Rooms' => [
            'title' => __d('hostel', 'List of Rooms'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Rooms',
                'action' => 'index',
            ],
            'weight' => 70,
            'children' => [
                'Add Room Type' => [
                    'title' => __d('menu', 'Add Room Type'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Rooms',
                        'action' => 'addRoomType',
                    ],
                    'weight' => 10,
                ],
                'Room Types' => [
                    'title' => __d('menu', 'Room Types'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Rooms',
                        'action' => 'roomTypes',
                    ],
                    'weight' => 10,
                ],
                'Add Room' => [
                    'title' => __d('menu', 'Add Room'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Rooms',
                        'action' => 'addRoom',
                    ],
                    'weight' => 5,
                ],

            ],
        ],
        'Allotement' => [
            'title' => __d('menu', 'Allotement'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Allotements',
            ],
            'weight' => 80,
            'children' => [
                'Add' => [
                    'title' => __d('menu', 'Add'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Allotements',
                        'action' => 'add',
                    ],
                    'weight' => 10,
                ],
                'Allotement List' => [
                    'title' => __d('menu', 'Allotement List'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Allotements',
                        'action' => 'index',
                    ],
                    'weight' => 10,
                ],
            ],
        ],

    ],
]);

Nav::add('sidebar', 'Admissions', [
    'icon' => 'bookmark',
    'title' => __d('menu', 'Admissions'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Students',
        'action' => 'tindex',
    ],
    'weight' => 170,
    'children' => [
        'Admissions List' => [
            'title' => __d('menu', 'Admissions'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'tindex',
            ],
            'weight' => 20,
        ],
    'Admission upload' => [
            'title' => __d('menu', 'Admission upload'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'admissionUpload',
            ],
            'weight' => 20,
        ],
        'Payment List' => [
            'title' => __d('menu', 'Payment List'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Students',
                'action' => 'paymentList',
            ],
            'weight' => 20,
        ],
    ],
]);

Nav::add('sidebar', 'Employee', [
    'icon' => 'users',
    'title' => __d('menu', 'Employee'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Employees',
        'action' => 'index',
    ],
    'weight' => 180,
    'children' => [
        'Profile' => [
            'title' => __d('menu', 'Profile'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Employees',

            ],
            'weight' => 10,
            'children' => [
                'viewProfile' => [
                    'title' => __d('menu', 'View Profile'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Employees',
                        'action' => 'profile',
                    ],
                    'weight' => 20,
                ],
                'leave' => [
                    'title' => __d('menu', 'Leave'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Employees',
                        'action' => 'leave',
                    ],
                    'weight' => 30,
                ],
                'Calender' => [
                    'title' => __d('menu', 'Calender'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Employees',
                        'action' => 'Calender',
                    ],
                    'weight' => 40,
                ],
            ],
        ],
        'AllEmployee' => [
            'title' => __d('menu', 'All Employee'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Employees',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
        'Designation' => [
            'title' => __d('menu', 'Designation'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Employees',
                'action' => 'designation',
            ],
            'weight' => 30,
        ],
        'inactiveEmployees' => [
            'title' => __d('menu', 'Inactive Employees'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Employees',
                'action' => 'inactiveEmployees',
            ],
            'weight' => 40,
        ],
        'exEmployees' => [
            'title' => __d('menu', 'EX-Employees'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Employees',
                'action' => 'exEmployees',
            ],
            'weight' => 50,
        ],
    ],
]);

Nav::add('sidebar', 'Certificates', [
    'icon' => 'certificate',
    'title' => __d('menu', 'Certificates'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Certificates',
        'action' => 'index',
    ],
    'weight' => 210,
    'children' => [
        'Configuration' => [
            'title' => __d('menu', 'Configuration'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Certificates',
                'action' => 'index',
            ],
            'weight' => 10,
            'children' => [
                'Certificate Type' => [
                    'title' => __d('menu', 'Certificate Type'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Certificates',
                        'action' => 'allTypes',
                    ],
                    'weight' => 10,
                ],
                'Tags' => [
                    'title' => __d('menu', 'Tags'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Certificates',
                        'action' => 'allTags',
                    ],
                    'weight' => 20,
                ],
                'Configuration' => [
                    'title' => __d('menu', 'All Configuration'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Certificates',
                        'action' => 'configCirtificates',
                    ],
                    'weight' => 30,
                ],
            ],
        ],
        'Certificates' => [
            'title' => __d('menu', 'Certificates'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Certificates',
                'action' => 'index',
            ],
            'weight' => 20,
            'children' => [
                'Certificate Type' => [
                    'title' => __d('menu', 'Add Certificate'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Certificates',
                        'action' => 'addCertificates',
                    ],
                    'weight' => 10,
                ],
                'View Certificates' => [
                    'title' => __d('menu', 'View Certificates'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Croogo/Core',
                        'controller' => 'Certificates',
                        'action' => 'viewCertificates',
                    ],
                    'weight' => 20,
                ],
            ],
        ],
    ],
]);

Nav::add('sidebar', 'Library Section', [
    'icon' => 'book',
    'title' => __d('menu', 'Library Section'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Library',
        'action' => 'index',
    ],
    'weight' => 220,
    'children' => [
        'Books' => [
            'title' => __d('menu', 'Books'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Library',
                'action' => 'books',
            ],
            'weight' => 10,
        ],
        'allIssues' => [
            'title' => __d('menu', 'Issued Books'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Library',
                'action' => 'allIssues',
            ],
            'weight' => 20,
        ],
        'Return Books' => [
            'title' => __d('menu', 'Return Books'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Library',
                'action' => 'returnBooks',
            ],
            'weight' => 30,
        ],
        'Members' => [
            'title' => __d('menu', 'Members'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Library',
                'action' => 'members',
            ],
            'weight' => 40,
        ],
    ],
]);

//Nav Menu Gallery by @shihab
Nav::add('sidebar', 'Gallery', [
    'icon' => 'camera',
    'title' => __d('gallery', 'Gallery'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Album',
        'action' => 'viewAlbum',
    ],
    'weight' => 55,
    'children' => [
        'ListofAlbums' => [ // students is a example but there must be different name for different menu
            'title' => __d('gallery', 'List of Albums'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Album',
                'action' => 'viewAlbum',
            ],
            'weight' => 10,
        ],
        'List of Photos' => [
            'title' => __d('gallery', 'List of Photos'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Photos',
                'action' => 'viewPhotos',
            ],
            'weight' => 100,
        ],
    ],
]);

Nav::add('sidebar', 'CMS', [
    'icon' => 'desktop',
    'title' => __d('boxes', 'CMS'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Cms',
        'action' => 'boxes',
    ],
    'weight' => 56,
    'children' => [
        'ListofBoxes' => [
            'title' => __d('boxes', 'List of Boxes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Cms',
                'action' => 'Boxes',
            ],
            'weight' => 10,
        ],
        'ListofConfigs' => [
            'title' => __d('boxes', 'List of Configs'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Cms',
                'action' => 'pageConfig',
            ],
            'weight' => 101,
        ],
        'QuickLink' => [
            'title' => __d('boxes', 'Quick Links'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Cms',
                'action' => 'quickLink',
            ],
            'weight' => 111,
        ],
    ],
]);

//Nav Menu Admit Card by @shovon
Nav::add('sidebar', 'Admit Card', [
    'icon' => 'address-card',
    'title' => __d('admit', 'Admit Card'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Core',
        'controller' => 'Admit',
        'action' => 'index',
    ],
    'weight' => 55,
    'children' => [
        'Admit Cards' => [
            'title' => __d('admit', 'List of Admit Cards'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'Bench Slip' => [
            'title' => __d('admit', 'Bench Slip'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Admit',
                'action' => 'slip',
            ],
            'weight' => 100,
        ],
    ],
]);
