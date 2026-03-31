<?php

use Cake\Core\Configure;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Croogo\Core\Utility\StringConverter;

Router::prefix('admin', function (RouteBuilder $routeBuilder) {
    $routeBuilder->registerMiddleware('csrf', new CsrfProtectionMiddleware());
    $routeBuilder->applyMiddleware('csrf');

    $dashboardUrl = Configure::read('Site.dashboard_url');
    if (!$dashboardUrl) {
        return;
    }

    if (is_string($dashboardUrl)) {
        $converter = new StringConverter();
        $dashboardUrl = $converter->linkStringToArray($dashboardUrl);
    }

    $routeBuilder->connect('/', $dashboardUrl);
});

Router::plugin('Croogo/Core', ['path' => '/'], function ($routes) {
    $routes->prefix('', function ($routes) {
        // Define your API routes here
        $routes->connect('/cfGetFeeInfo', ['controller' => 'OnlinePayment', 'action' => 'cfGetFeeInfo']);
    });
});

Router::plugin(
    'Croogo/Core',
    ['path' => '/'],
    function (RouteBuilder $routeBuilder) {
        $routeBuilder->prefix('admin', function (RouteBuilder $routeBuilder) {
            $routeBuilder->setExtensions(['json']);
            $routeBuilder->applyMiddleware('csrf');

            //Route for StudentsController @shihab
            $routeBuilder->connect('/students/upload_image/*', [
                'controller' => 'Students',
                'action' => 'uploadImage',
            ]);
            $routeBuilder->connect('/students/custom_roll/', [
                'controller' => 'Students',
                'action' => 'customRoll'
            ]);
            $routeBuilder->connect('/students/index', [
                'controller' => 'Students',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/students/active_status_log', [
                'controller' => 'Students',
                'action' => 'activeStatus'
            ]);
            $routeBuilder->connect('/students/add/', [
                'controller' => 'Students',
                'action' => 'add'
            ]);
            $routeBuilder->connect('/students/promotion/', [
                'controller' => 'Students',
                'action' => 'promotion',
            ]);
            $routeBuilder->connect('/students/promotionLog/', [
                'controller' => 'Students',
                'action' => 'promotionLog',
            ]);
            $routeBuilder->connect('/students/deletePromotion/*', [
                'controller' => 'Students',
                'action' => 'deletePromotion',
            ]);
            $routeBuilder->connect('/students/promotionTemplate/', [
                'controller' => 'Students',
                'action' => 'promotionTemplate',
            ]);
            $routeBuilder->connect('/students/addPromotionTemplate/', [
                'controller' => 'Students',
                'action' => 'addPromotionTemplate',
            ]);
            $routeBuilder->connect('/students/viewPromotionTemplate/*', [
                'controller' => 'Students',
                'action' => 'viewPromotionTemplate',
            ]);
            $routeBuilder->connect('/students/deletePromotionTemplate/*', [
                'controller' => 'Students',
                'action' => 'deletePromotionTemplate',
            ]);
            $routeBuilder->connect('/students/getTermForPromotionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermForPromotionAjax',
            ]);
            
            $routeBuilder->connect('/students/getPromotionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getPromotionAjax',
            ]);

            $routeBuilder->connect('/students/IndividualPromotion/', [
                'controller' => 'Students',
                'action' => 'individualPromotion',
            ]);

            $routeBuilder->connect('/students/getSectionForPromotionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionForPromotionAjax',
            ]);

            $routeBuilder->connect('/students/getSectionAjaxbylevelfrom/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjaxbylevelfrom',
            ]);
            $routeBuilder->connect('/students/getSectionAjaxbylevelto/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjaxbylevelto',
            ]);

            $routeBuilder->connect('/students/getCodeAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getCodeAjax',
            ]);

            $routeBuilder->connect('/students/import/', [
                'controller' => 'Students',
                'action' => 'import',
            ]);
            $routeBuilder->connect('/students/edit/*', [
                'controller' => 'Students',
                'action' => 'edit',
            ]);
            $routeBuilder->connect('/students/print/*', [
                'controller' => 'Students',
                'action' => 'print'
            ]);
            $routeBuilder->connect('/students/deleteCycle/*', [
                'controller' => 'Students',
                'action' => 'deleteCycle',
            ]);
            $routeBuilder->connect('/students/delete_cycle/*', [
                'controller' => 'Students',
                'action' => 'deleteCycle',
            ]);
            $routeBuilder->connect('/students/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/students/edit/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/students/getSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSubjectAjax',
            ]);
            $routeBuilder->connect('/students/getReligionSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getReligionSubjectAjax',
            ]);
            $routeBuilder->connect('/students/addResult/', [
                'controller' => 'Students',
                'action' => 'addResult',
            ]);
            $routeBuilder->connect('/students/getTermAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermAjax',
            ]);
            $routeBuilder->connect('/students/getGroupAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getGroupAjax',
            ]);
            $routeBuilder->connect('/students/getThirdForthAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getThirdForthAjax',
            ]);
            $routeBuilder->connect('/students/edit/getGroupAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getGroupAjax',
            ]);
            $routeBuilder->connect('/students/edit/getReligionSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getReligionSubjectAjax',
            ]);
            $routeBuilder->connect('/students/edit/getThirdForthAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getThirdForthAjax',
            ]);

            $routeBuilder->connect('/students/getallSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getallSubjectAjax',
            ]);
            $routeBuilder->connect('/students/getResultSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getResultSubjectAjax',
            ]);
            $routeBuilder->connect('/students/addQuizResult/', [
                'controller' => 'Students',
                'action' => 'addQuizResult',
            ]);
            $routeBuilder->connect('/students/getQuizSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getQuizSubjectAjax',
            ]);
            $routeBuilder->connect('/students/addActivityResult/', [
                'controller' => 'Students',
                'action' => 'addActivityResult',
            ]);

            $routeBuilder->connect('/students/getActivityAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getActivityAjax',
            ]);
            $routeBuilder->connect('/students/getPartType/*', [
                'controller' => 'Ajax',
                'action' => 'getPartType',
            ]);
            $routeBuilder->connect('/students/tedit/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/students/tedit/getSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSubjectAjax',
            ]);
            $routeBuilder->connect('/students/tedit/getReligionSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getReligionSubjectAjax',
            ]);
            $routeBuilder->connect('/students/getQuizAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getQuizAjax',
            ]);

            $routeBuilder->connect('/students/seatplan', [
                'controller' => 'Students',
                'action' => 'seatplan'
            ]);
            $routeBuilder->connect('/students/addSeatplan', [
                'controller' => 'Students',
                'action' => 'addSeatplan'
            ]);
            $routeBuilder->connect('/students/admissionRoom', [
                'controller' => 'Students',
                'action' => 'admissionRoom'
            ]);
            $routeBuilder->connect('/students/viewSeatplan', [
                'controller' => 'Students',
                'action' => 'viewSeatplan'
            ]);
            $routeBuilder->connect('/students/tindex', [
                'controller' => 'Students',
                'action' => 'tindex'
            ]);
            $routeBuilder->connect('/students/tedit/*', [
                'controller' => 'Students',
                'action' => 'tedit',
            ]);
            $routeBuilder->connect('/students/admission_upload/*', [
                'controller' => 'Students',
                'action' => 'admissionUpload'
            ]);
            $routeBuilder->connect('/students/tution_fees/*', [
                'controller' => 'Students',
                'action' => 'tutionFees',
            ]);
            $routeBuilder->connect('/students/promotion_list/*', [
                'controller' => 'Students',
                'action' => 'promotionList',
            ]);
            $routeBuilder->connect('/students/data_settings/*', [
                'controller' => 'Students',
                'action' => 'dataSettings',
            ]);
            $routeBuilder->connect('/students/data_count/*', [
                'controller' => 'Students',
                'action' => 'dataCount',
            ]);
            $routeBuilder->connect('/students/edit_count/*', [
                'controller' => 'Students',
                'action' => 'editCount',
            ]);
            $routeBuilder->connect('/students/datas/*', [
                'controller' => 'Students',
                'action' => 'datas',
            ]);
            $routeBuilder->connect('/students/number_fordo/*', [
                'controller' => 'Students',
                'action' => 'numberFordo',
            ]);
            $routeBuilder->connect('/students/export/*', [
                'controller' => 'Students',
                'action' => 'export',
            ]);
            $routeBuilder->connect('/students/image_download/*', [
                'controller' => 'Students',
                'action' => 'imageDownload',
            ]);
            $routeBuilder->connect('/students/delete_download/*', [
                'controller' => 'Students',
                'action' => 'deleteDownload',
            ]);
            $routeBuilder->connect('/students/mark_entry_report/*', [
                'controller' => 'Students',
                'action' => 'markEntryReport',
            ]);
            $routeBuilder->connect('/students/upload/*', [
                'controller' => 'Students',
                'action' => 'upload',
            ]);
            $routeBuilder->connect('/students/getTermForPromotionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermForPromotionAjax',
            ]);
            $routeBuilder->connect('/students/getSectionForPromotionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionForPromotionAjax',
            ]);

            $routeBuilder->connect('/students/payment_list/*', [
                'controller' => 'Students',
                'action' => 'paymentList',
            ]);
            $routeBuilder->connect('/students/add_payment/*', [
                'controller' => 'Students',
                'action' => 'addPayment',
            ]);
            $routeBuilder->connect('/students/add_edit_payment/*', [
                'controller' => 'Students',
                'action' => 'addeditPayment',
            ]);
            $routeBuilder->connect('/students/refactorCycle/', [
                'controller' => 'Students',
                'action' => 'refactorCycle',
            ]);
            $routeBuilder->connect('/students/individual_term_assign/', [
                'controller' => 'Students',
                'action' => 'individualTermAssign',
            ]);
            $routeBuilder->connect('/students/viewCycle/', [
                'controller' => 'Students',
                'action' => 'viewCycle',
            ]);
            $routeBuilder->connect('/studentCycleDetails/*', [
                'controller' => 'Students',
                'action' => 'studentCycleDetails',
            ]);
            $routeBuilder->connect('/studentCycleAddCourse/*', [
                'controller' => 'Students',
                'action' => 'studentCycleAddCourse',
            ]);

            $routeBuilder->connect('/deleteStudentTermCourseCycle/*', [
                'controller' => 'Students',
                'action' => 'deleteStudentTermCourseCycle',
            ]);

            //Route for StaffsController @shihab
            $routeBuilder->connect('/setup', [
                'controller' => 'Setup',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/setup/faculty/', [
                'controller' => 'Setup',
                'action' => 'faculty'
            ]);
            $routeBuilder->connect('/setup/addFaculty/', [
                'controller' => 'Setup',
                'action' => 'addFaculty'
            ]);
            $routeBuilder->connect('/setup/renew/', [
                'controller' => 'Setup',
                'action' => 'renew'
            ]);
            $routeBuilder->connect('/setup/renew_report/', [
                'controller' => 'Setup',
                'action' => 'renewReport'
            ]);
            $routeBuilder->connect('/setup/editFaculty/*', [
                'controller' => 'Setup',
                'action' => 'editFaculty'
            ]);
            $routeBuilder->connect('/setup/department/', [
                'controller' => 'Setup',
                'action' => 'department'
            ]);
            $routeBuilder->connect('/setup/addDepartment/', [
                'controller' => 'Setup',
                'action' => 'addDepartment'
            ]);
            $routeBuilder->connect('/setup/editDepartment/*', [
                'controller' => 'Setup',
                'action' => 'editDepartment'
            ]);
            $routeBuilder->connect('/setup/level/', [
                'controller' => 'Setup',
                'action' => 'level'
            ]);
            $routeBuilder->connect('/setup/addLevel/', [
                'controller' => 'Setup',
                'action' => 'addLevel'
            ]);
            $routeBuilder->connect('/setup/editlevel/*', [
                'controller' => 'Setup',
                'action' => 'editLevel'
            ]);

            $routeBuilder->connect('/setup/section/', [
                'controller' => 'Setup',
                'action' => 'section'
            ]);
            $routeBuilder->connect('/setup/addSection/', [
                'controller' => 'Setup',
                'action' => 'addSection'
            ]);
            $routeBuilder->connect('/setup/editSection/*', [
                'controller' => 'Setup',
                'action' => 'editSection'
            ]);
            $routeBuilder->connect('/setup/session/', [
                'controller' => 'Setup',
                'action' => 'session'
            ]);
            $routeBuilder->connect('/setup/addSession/', [
                'controller' => 'Setup',
                'action' => 'addSession'
            ]);
            $routeBuilder->connect('/setup/editSession/*', [
                'controller' => 'Setup',
                'action' => 'editSession'
            ]);
            $routeBuilder->connect('/setup/shift/', [
                'controller' => 'Setup',
                'action' => 'shift'
            ]);
            $routeBuilder->connect('/setup/addShift/', [
                'controller' => 'Setup',
                'action' => 'addShift'
            ]);
            $routeBuilder->connect('/setup/editShift/*', [
                'controller' => 'Setup',
                'action' => 'editShift'
            ]);
            $routeBuilder->connect('/setup/getLevelsAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getLevelsAjax'
            ]);
            $routeBuilder->connect('/setup/course/', [
                'controller' => 'Setup',
                'action' => 'course'
            ]);
            $routeBuilder->connect('/setup/add_course/', [
                'controller' => 'Setup',
                'action' => 'addCourse'
            ]);
            $routeBuilder->connect('/setup/edit_course/*', [
                'controller' => 'Setup',
                'action' => 'editCourse'
            ]);
            $routeBuilder->connect('/setup/courses_cycle/', [
                'controller' => 'Setup',
                'action' => 'coursesCycle'
            ]);
            $routeBuilder->connect('/setup/add_courses_cycle/', [
                'controller' => 'Setup',
                'action' => 'addCoursesCycle'
            ]);
            $routeBuilder->connect('/setup/edit_courses_cycle/*', [
                'controller' => 'Setup',
                'action' => 'editCoursesCycle'
            ]);
            $routeBuilder->connect('/setup/marks_distribution/', [
                'controller' => 'Setup',
                'action' => 'marksDistribution'
            ]);
            $routeBuilder->connect('/setup/add_marks_distribution/', [
                'controller' => 'Setup',
                'action' => 'addMarksDistribution'
            ]);
            $routeBuilder->connect('/setup/edit_marks_distribution/*', [
                'controller' => 'Setup',
                'action' => 'editMarksDistribution'
            ]);
            $routeBuilder->connect('/setup/term', [
                'controller' => 'Setup',
                'action' => 'term'
            ]);
            $routeBuilder->connect('/setup/add_term/', [
                'controller' => 'Setup',
                'action' => 'addTerm'
            ]);
            $routeBuilder->connect('/setup/edit_term/*', [
                'controller' => 'Setup',
                'action' => 'editTerm'
            ]);
            $routeBuilder->connect('/setup/term_cycle', [
                'controller' => 'Setup',
                'action' => 'termCycle'
            ]);
            $routeBuilder->connect('/setup/detailsTermCycle/*', [
                'controller' => 'Setup',
                'action' => 'detailsTermCycle'
            ]);
            $routeBuilder->connect('/setup/termCycleAddCourse/*', [
                'controller' => 'Setup',
                'action' => 'termCycleAddCourse'
            ]);
            $routeBuilder->connect('/setup/add_term_cycle/', [
                'controller' => 'Setup',
                'action' => 'addTermCycle'
            ]);
            $routeBuilder->connect('/setup/term_courses_list/', [
                'controller' => 'Setup',
                'action' => 'termCoursesList'
            ]);
            $routeBuilder->connect('/setup/select_session/', [
                'controller' => 'Setup',
                'action' => 'selectSession'
            ]);
            $routeBuilder->connect('/accounts/getUserAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getUserAjax',
            ]);
            $routeBuilder->connect('/accounts/getPurposeAjax/*', [
                'controller' => 'ajax',
                'action' => 'getPurposeAjax'
            ]);
            $routeBuilder->connect('/accounts/schoolFees/', [
                'controller' => 'accounts',
                'action' => 'schoolFees'
            ]);
            $routeBuilder->connect('/accounts/two_taka_fund/', [
                'controller' => 'accounts',
                'action' => 'twoTakafund'
            ]);
            $routeBuilder->connect('/accounts/getVouchersAjax/*', [
                'controller' => 'ajax',
                'action' => 'getVouchersAjax'
            ]);
            $routeBuilder->connect('/accounts/getMonthsForVoucherAjax/*', [
                'controller' => 'ajax',
                'action' => 'getMonthsForVoucherAjax'
            ]);
            $routeBuilder->connect('/accounts/getPurposeMonthAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getPurposeMonthAjax',
            ]);
            $routeBuilder->connect('/accounts/getMonthsForIndivisulVoucherAjax/*', [
                'controller' => 'ajax',
                'action' => 'getMonthsForIndivisulVoucherAjax'
            ]);
            $routeBuilder->connect('/accounts/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/setup/getCoursesAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getCoursesAjax'
            ]);
            $routeBuilder->connect('/setup/getLevelAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getLevelAjax'
            ]);
            $routeBuilder->connect('/setup/getTermAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermAjax',
            ]);
            $routeBuilder->connect('/setup/editTermCourse/*', [
                'controller' => 'Setup',
                'action' => 'editTermCourse'
            ]);
            $routeBuilder->connect('/setup/editQuiz/*', [
                'controller' => 'Setup',
                'action' => 'editQuiz'
            ]);

            $routeBuilder->connect('/setup/addActivityCycle', [
                'controller' => 'Setup',
                'action' => 'addActivityCycle'
            ]);
            $routeBuilder->connect('/setup/activityCycle', [
                'controller' => 'Setup',
                'action' => 'activityCycle'
            ]);
            $routeBuilder->connect('/setup/activity', [
                'controller' => 'Setup',
                'action' => 'activity'
            ]);
            $routeBuilder->connect('/setup/add_activity/', [
                'controller' => 'Setup',
                'action' => 'addActivity'
            ]);
            $routeBuilder->connect('/setup/edit_activity/*', [
                'controller' => 'Setup',
                'action' => 'editActivity'
            ]);

            $routeBuilder->connect('/setup/courseCyclePromotion', [
                'controller' => 'Setup',
                'action' => 'courseCyclePromotion'
            ]);
            $routeBuilder->connect('/setup/activityCyclePromotion', [
                'controller' => 'Setup',
                'action' => 'activityCyclePromotion'
            ]);
            $routeBuilder->connect('/setup/termCyclePromotion/', [
                'controller' => 'Setup',
                'action' => 'termCyclePromotion'
            ]);

            $routeBuilder->connect('/setup/deleteCourseCycle/*', [
                'controller' => 'Ajax',
                'action' => 'deleteCourseCycle'
            ]);
            $routeBuilder->connect('/setup/deleteActivityCycle/*', [
                'controller' => 'Ajax',
                'action' => 'deleteActivityCycle'
            ]);
            $routeBuilder->connect('/setup/detailsTermCycle/deleteTermCourseCycle/*', [
                'controller' => 'Ajax',
                'action' => 'deleteTermCourseCycle'
            ]);
            $routeBuilder->connect('/setup/detailsTermCycle/deleteTermActivityCycle/*', [
                'controller' => 'Ajax',
                'action' => 'deleteTermActivityCycle'
            ]);
            $routeBuilder->connect('/cms/quick_links/getBtnOrderAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getBtnOrderAjax'
            ]);
            $routeBuilder->connect('/cms/boxes/getBoxOrderAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getBoxOrderAjax'
            ]);
            $routeBuilder->connect('/employees/getEmployeeOrderAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getEmployeeOrderAjax'
            ]);

            //Route for TeachersController @shihab
            $routeBuilder->connect('/teachers', [
                'controller' => 'Teachers',
                'action' => 'index'
            ]);

            $routeBuilder->connect('/teachers/assignTeacher', [
                'controller' => 'Teachers',
                'action' => 'assignTeacher'
            ]);
            $routeBuilder->connect('/teachers/assignTeacherAdd', [
                'controller' => 'Teachers',
                'action' => 'assignTeacherAdd'
            ]);
            $routeBuilder->connect('/teachers/designation', [
                'controller' => 'Teachers',
                'action' => 'designation'
            ]);
            $routeBuilder->connect('/teachers/add_designation', [
                'controller' => 'Teachers',
                'action' => 'addDesignation'
            ]);
            $routeBuilder->connect('/teachers/edit_designation/*', [
                'controller' => 'Teachers',
                'action' => 'editDesignation'
            ]);
            $routeBuilder->connect('/teachers/deleteAssignTeacher/*', [
                'controller' => 'Teachers',
                'action' => 'deleteAssignTeacher'
            ]);
            $routeBuilder->connect('/teachers/getSectionAjaxbylevel/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjaxbylevel',
            ]);
            $routeBuilder->connect('/teachers/getSubjectAjaxbylevel/*', [
                'controller' => 'Ajax',
                'action' => 'getSubjectAjaxbylevel',
            ]);

            //Route for BuildingsController
            $routeBuilder->connect('/add_hostel/', [
                'controller' => 'Buildings',
                'action' => 'addHostel'
            ]);
            $routeBuilder->connect('/hostels/', [
                'controller' => 'Buildings',
                'action' => 'hostels'
            ]);
            $routeBuilder->connect('/hostel_edit/*', [
                'controller' => 'Buildings',
                'action' => 'editHostel'
            ]);
            $routeBuilder->connect('/buildings/add/', [
                'controller' => 'Buildings',
                'action' => 'addBuilding'
            ]);
            $routeBuilder->connect('/buildings/edit/*', [
                'controller' => 'Buildings',
                'action' => 'editBuilding'
            ]);
            $routeBuilder->connect('/buildings/delete/*', [
                'controller' => 'Buildings',
                'action' => 'deleteBuilding'
            ]);
            $routeBuilder->connect('/buildings/index/', [
                'controller' => 'Buildings',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/buildings/report/', [
                'controller' => 'Buildings',
                'action' => 'report'
            ]);
            $routeBuilder->connect('/buildings/getBuildingAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getBuildingAjax',
            ]);

            //Route for RoomsController
            $routeBuilder->connect('/rooms/add_room_type/', [
                'controller' => 'Rooms',
                'action' => 'addRoomType'
            ]);
            $routeBuilder->connect('/rooms/room_types/', [
                'controller' => 'Rooms',
                'action' => 'roomTypes'
            ]);
            $routeBuilder->connect('/rooms/edit_room_type/*', [
                'controller' => 'Rooms',
                'action' => 'editRoomType'
            ]);
            $routeBuilder->connect('/rooms/add/', [
                'controller' => 'Rooms',
                'action' => 'addRoom'
            ]);
            $routeBuilder->connect('/rooms/edit/*', [
                'controller' => 'Rooms',
                'action' => 'editRoom'
            ]);
            $routeBuilder->connect('/rooms/delete/*', [
                'controller' => 'Rooms',
                'action' => 'deleteRoom'
            ]);
            $routeBuilder->connect('/rooms/index/', [
                'controller' => 'Rooms',
                'action' => 'index'
            ]);

            //Route for AllotementsController
            $routeBuilder->connect('/allotements/add/', [
                'controller' => 'Allotements',
                'action' => 'add'
            ]);
            $routeBuilder->connect('/allotements/index/', [
                'controller' => 'Allotements',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/allotements/add/getRoomAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getRoomAjax',
            ]);
            $routeBuilder->connect('/rooms/edit/*', [
                'controller' => 'Rooms',
                'action' => 'editRoom'
            ]);
            $routeBuilder->connect('/rooms/delete/*', [
                'controller' => 'Rooms',
                'action' => 'deleteRoom'
            ]);
            $routeBuilder->connect('/rooms/index/', [
                'controller' => 'Rooms',
                'action' => 'index'
            ]);

            //Route for AttendanceController @shihab
            $routeBuilder->connect('/attendance', [
                'controller' => 'Attendance',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/attendance/deviceAttendence', [
                'controller' => 'Attendance',
                'action' => 'deviceAttendence'
            ]);
            $routeBuilder->connect('/attendance/deviceLog', [
                'controller' => 'Attendance',
                'action' => 'deviceLog'
            ]);
            $routeBuilder->connect('/attendance/monthly_attendence_report', [
                'controller' => 'Attendance',
                'action' => 'monthlyAttendenceReport'
            ]);
            $routeBuilder->connect('/attendance/attendanceSheet/', [
                'controller' => 'Attendance',
                'action' => 'attendanceSheet',
            ]);
            $routeBuilder->connect('/attendance/class_wise_attendance_report/', [
                'controller' => 'Attendance',
                'action' => 'atdReport',
            ]);
            $routeBuilder->connect('/attendance/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/attendance/edit/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/attendance/getCoursesAjax/*', [
                'controller' => 'Attendance',
                'action' => 'getCoursesAjax'
            ]);
            $routeBuilder->connect('/getAttendanceSectionAjax', [
                'controller' => 'Ajax',
                'action' => 'getAttendanceSectionAjax'
            ]);
            $routeBuilder->connect('/getAttandenceSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getAttandenceSubjectAjax',
            ]);

            $routeBuilder->connect('/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/getallSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getallSubjectAjax',
            ]);
            $routeBuilder->connect('/getTermAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermAjax',
            ]);
            $routeBuilder->connect('/students/getTermCycleAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermCycleAjax',
            ]);
            //AdmitController created by @shovon
            $routeBuilder->connect('/admit', [
                'controller' => 'Admit',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/individual_admit_card', [
                'controller' => 'Admit',
                'action' => 'individualAdmitCard'
            ]);
            $routeBuilder->connect('/admit_card', [
                'controller' => 'Admit',
                'action' => 'admitCard'
            ]);
            $routeBuilder->connect('/admit_card_students', [
                'controller' => 'Admit',
                'action' => 'admitCardStudents'
            ]);
            $routeBuilder->connect('/delete_admit_card_students', [
                'controller' => 'Admit',
                'action' => 'deleteAdmitCard'
            ]);
            $routeBuilder->connect('/delete_routine', [
                'controller' => 'Admit',
                'action' => 'deleteRoutine'
            ]);
            $routeBuilder->connect('/exam_attendance_sheet', [
                'controller' => 'Admit',
                'action' => 'examAttendance'
            ]);
            $routeBuilder->connect('/slip', [
                'controller' => 'Admit',
                'action' => 'slip'
            ]);
            $routeBuilder->connect('/getAdmitAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getAdmitAjax',
            ]);
            $routeBuilder->connect('/Ajax/getPromotionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getPromotionAjax',
            ]);
            $routeBuilder->connect('/attendance/getCoursesAjax/*', [
                'controller' => 'Admit',
                'action' => 'getCoursesAjax'
            ]);
            $routeBuilder->connect('/slip', [
                'controller' => 'Admit',
                'action' => 'slip'
            ]);
            $routeBuilder->connect('/attendance/getCoursesAjax/*', [
                'controller' => 'Admit',
                'action' => 'getCoursesAjax'
            ]);
            $routeBuilder->connect('/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/getallSubjectAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getallSubjectAjax',
            ]);
            $routeBuilder->connect('/getTermAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermAjax',
            ]);

            //Route for SmsController @shihab
            $routeBuilder->connect('/sms', [
                'controller' => 'Sms',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/other_sms', [
                'controller' => 'Sms',
                'action' => 'otherSms'
            ]);
            $routeBuilder->connect('/sms/smsPermission', [
                'controller' => 'Sms',
                'action' => 'smsPermission'
            ]);
            $routeBuilder->connect('/sms/sms_logs', [
                'controller' => 'Sms',
                'action' => 'smsLogs'
            ]);

            //Route for StaffsController @shihab
            $routeBuilder->connect('/staffs', [
                'controller' => 'Staffs',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/staffs/edit/*', [
                'controller' => 'Staffs',
                'action' => 'edit'
            ]);
            $routeBuilder->connect('/staffs/delete/*', [
                'controller' => 'Staffs',
                'action' => 'delete'
            ]);

            //Route for EmployeesController @shihab
            $routeBuilder->connect('/employees', [
                'controller' => 'Employees',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/generate_uniqe_id', [
                'controller' => 'Employees',
                'action' => 'updateUniqueIds'
            ]);
            $routeBuilder->connect('/ex-employees', [
                'controller' => 'Employees',
                'action' => 'exEmployees'
            ]);
            $routeBuilder->connect('/inactive_employees', [
                'controller' => 'Employees',
                'action' => 'inactiveEmployees'
            ]);
            $routeBuilder->connect('/employees/add', [
                'controller' => 'Employees',
                'action' => 'addEmployee'
            ]);
            $routeBuilder->connect('/employees/edit/*', [
                'controller' => 'Employees',
                'action' => 'edit'
            ]);
            $routeBuilder->connect('/employees/delete/*', [
                'controller' => 'Employees',
                'action' => 'deleteEmployee'
            ]);
            $routeBuilder->connect('/employees/profile', [
                'controller' => 'Employees',
                'action' => 'profile'
            ]);
            $routeBuilder->connect('/employees/liveClass', [
                'controller' => 'Employees',
                'action' => 'liveClass'
            ]);
            $routeBuilder->connect('/employees/classList', [
                'controller' => 'Employees',
                'action' => 'classList'
            ]);
            $routeBuilder->connect('/employees/endClass/*', [
                'controller' => 'Employees',
                'action' => 'endClass'
            ]);
            $routeBuilder->connect('/employees/leave', [
                'controller' => 'Employees',
                'action' => 'leave'
            ]);
            $routeBuilder->connect('/employees/addLeave', [
                'controller' => 'Employees',
                'action' => 'addLeave'
            ]);
            $routeBuilder->connect('/employees/edit_leave/*', [
                'controller' => 'Employees',
                'action' => 'editLeave'
            ]);
            $routeBuilder->connect('/employees/calender', [
                'controller' => 'Employees',
                'action' => 'Calender'
            ]);
            $routeBuilder->connect('/employees/designation', [
                'controller' => 'Employees',
                'action' => 'designation'
            ]);
            $routeBuilder->connect('/employees/addDesignation', [
                'controller' => 'Employees',
                'action' => 'addDesignation'
            ]);
            $routeBuilder->connect('/employees/editDesignation/*', [
                'controller' => 'Employees',
                'action' => 'editDesignation'
            ]);
            $routeBuilder->connect('/employees/permissions/*', [
                'controller' => 'Employees',
                'action' => 'permissions'
            ]);

            //Route for AccountsController @shihab
            $routeBuilder->connect('/accounts', [
                'controller' => 'accounts',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/accounts/banks/', [
                'controller' => 'accounts',
                'action' => 'banks'
            ]);
            $routeBuilder->connect('/accounts/add_bank/', [
                'controller' => 'accounts',
                'action' => 'addBank'
            ]);
            $routeBuilder->connect('/accounts/edit_bank/*', [
                'controller' => 'accounts',
                'action' => 'editBank'
            ]);
            $routeBuilder->connect('/accounts/delete_bank/*', [
                'controller' => 'accounts',
                'action' => 'deleteBank'
            ]);
            $routeBuilder->connect('/accounts/purposes/', [
                'controller' => 'accounts',
                'action' => 'Purposes'
            ]);
            $routeBuilder->connect('/accounts/add_purpose/', [
                'controller' => 'accounts',
                'action' => 'addPurpose'
            ]);
            $routeBuilder->connect('/accounts/edit_purpose/*', [
                'controller' => 'accounts',
                'action' => 'editPurpose'
            ]);
            $routeBuilder->connect('/accounts/delete_purpose/*', [
                'controller' => 'accounts',
                'action' => 'deletePurpose'
            ]);
            $routeBuilder->connect('/accounts/transactions/', [
                'controller' => 'accounts',
                'action' => 'Transactions'
            ]);
            $routeBuilder->connect('/accounts/add_debit/', [
                'controller' => 'accounts',
                'action' => 'addDebit'
            ]);
            $routeBuilder->connect('/accounts/add_credit/', [
                'controller' => 'accounts',
                'action' => 'addCredit'
            ]);
            $routeBuilder->connect('/accounts/add_voucher/', [
                'controller' => 'accounts',
                'action' => 'addVoucher'
            ]);
            $routeBuilder->connect('/accounts/credit_list/', [
                'controller' => 'accounts',
                'action' => 'creditList'
            ]);
            $routeBuilder->connect('/accounts/debit_list/', [
                'controller' => 'accounts',
                'action' => 'debitList'
            ]);
            $routeBuilder->connect('/accounts/purpose_wise_report/', [
                'controller' => 'accounts',
                'action' => 'purposeWise'
            ]);
            $routeBuilder->connect('/accounts/getMonthsFrromSessionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getMonthsFrromSessionAjax',
            ]);
            $routeBuilder->connect('/accounts/edit_transaction/*', [
                'controller' => 'accounts',
                'action' => 'editTransaction'
            ]);
            $routeBuilder->connect('/accounts/editDebit/*', [
                'controller' => 'accounts',
                'action' => 'editDebit'
            ]);
            $routeBuilder->connect('/accounts/editCredit/*', [
                'controller' => 'accounts',
                'action' => 'editCredit'
            ]);
            $routeBuilder->connect('/accounts/deleteVoucher/*', [
                'controller' => 'accounts',
                'action' => 'deleteVoucher'
            ]);
            $routeBuilder->connect('/accounts/editUnpaidVouchers/*', [
                'controller' => 'accounts',
                'action' => 'editUnpaidVouchers'
            ]);
            $routeBuilder->connect('/accounts/delete_transaction/*', [
                'controller' => 'accounts',
                'action' => 'deleteTransaction'
            ]);
            $routeBuilder->connect('/accounts/report/', [
                'controller' => 'accounts',
                'action' => 'report'
            ]);
            $routeBuilder->connect('/accounts/transactionStatement/', [
                'controller' => 'accounts',
                'action' => 'transactionStatement'
            ]);
            $routeBuilder->connect('/accounts/paymentDetails/', [
                'controller' => 'accounts',
                'action' => 'paymentDetails'
            ]);
            $routeBuilder->connect('/accounts/bank_statement_report/', [
                'controller' => 'accounts',
                'action' => 'bankStatementReport'
            ]);
            $routeBuilder->connect('/accounts/balance_report/', [
                'controller' => 'accounts',
                'action' => 'balanceReport'
            ]);
            $routeBuilder->connect('/accounts/voucherStatement/', [
                'controller' => 'accounts',
                'action' => 'voucherStatement'
            ]);
            $routeBuilder->connect('/accounts/dueReport/', [
                'controller' => 'accounts',
                'action' => 'dueReport'
            ]);
            $routeBuilder->connect('/accounts/due_sms/', [
                'controller' => 'accounts',
                'action' => 'dueSms'
            ]);
            $routeBuilder->connect('/accounts/classwise_fees_credit_report/', [
                'controller' => 'accounts',
                'action' => 'classwiseFeesCreditReport'
            ]);
            $routeBuilder->connect('/accounts/banks/deleted_banks/*', [
                'controller' => 'accounts',
                'action' => 'deletedBanks'
            ]);
            $routeBuilder->connect('/accounts/purposes/deleted_purposes/*', [
                'controller' => 'accounts',
                'action' => 'deletedPurposes'
            ]);
            $routeBuilder->connect('/accounts/transactions/deleted_transactions/*', [
                'controller' => 'accounts',
                'action' => 'deletedTransactions'
            ]);
            $routeBuilder->connect('/accounts/banks/restore_banks/*', [
                'controller' => 'accounts',
                'action' => 'restoreBanks'
            ]);
            $routeBuilder->connect('/accounts/purposes/restore_purposes/*', [
                'controller' => 'accounts',
                'action' => 'restorePurposes'
            ]);
            $routeBuilder->connect('/accounts/fees_khat_settings/', [
                'controller' => 'accounts',
                'action' => 'feesKhatSettings'
            ]);
            $routeBuilder->connect('/accounts/multiple_fees_khat/', [
                'controller' => 'accounts',
                'action' => 'multipleFeesKhat'
            ]);
            $routeBuilder->connect('/accounts/individual_voucher/', [
                'controller' => 'accounts',
                'action' => 'individualVoucher'
            ]);
            $routeBuilder->connect('/accounts/voucher_generate/', [
                'controller' => 'accounts',
                'action' => 'voucherGenerate'
            ]);
            $routeBuilder->connect('/accounts/unpaidVouchers/', [
                'controller' => 'accounts',
                'action' => 'unpaidVouchers'
            ]);
            $routeBuilder->connect('/accounts/additional_fees/', [
                'controller' => 'accounts',
                'action' => 'additionalFees'
            ]);
            $routeBuilder->connect('/accounts/add_additional_fees/', [
                'controller' => 'accounts',
                'action' => 'addAdditionalFees'
            ]);
            $routeBuilder->connect('/accounts/edit_additional_fees/*', [
                'controller' => 'accounts',
                'action' => 'editAdditionalFees'
            ]);
            $routeBuilder->connect('/accounts/generate_additional_fees/', [
                'controller' => 'accounts',
                'action' => 'generateAdditionalFees'
            ]);
            $routeBuilder->connect('/accounts/individualFees/', [
                'controller' => 'accounts',
                'action' => 'individualFees'
            ]);
            $routeBuilder->connect('/accounts/getOnlySessionMonthsAjax/*', [
                'controller' => 'ajax',
                'action' => 'getOnlySessionMonthsAjax'
            ]);
            $routeBuilder->connect('/moneyRecpit/*', [
                'controller' => 'accounts',
                'action' => 'moneyRecpit'
            ]);

            //Route for HrsController @shihab
            $routeBuilder->connect('/hrs', [
                'controller' => 'Hrs',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/hrs/shifts/', [
                'controller' => 'Hrs',
                'action' => 'shifts'
            ]);
            $routeBuilder->connect('/hrs/add_shift/', [
                'controller' => 'Hrs',
                'action' => 'addShift'
            ]);
            $routeBuilder->connect('/hrs/edit_shift/*', [
                'controller' => 'Hrs',
                'action' => 'editShift'
            ]);
            $routeBuilder->connect('/hrs/config/', [
                'controller' => 'Hrs',
                'action' => 'config'
            ]);
            $routeBuilder->connect('/hrs/add_config/', [
                'controller' => 'Hrs',
                'action' => 'addConfig'
            ]);
            $routeBuilder->connect('/hrs/edit_config/*', [
                'controller' => 'Hrs',
                'action' => 'editConfig'
            ]);
            $routeBuilder->connect('/hrs/config_setup/', [
                'controller' => 'Hrs',
                'action' => 'configSetup'
            ]);
            $routeBuilder->connect('/hrs/add_config_setup/', [
                'controller' => 'Hrs',
                'action' => 'addConfigSetup'
            ]);
            $routeBuilder->connect('/hrs/edit_config_setup/*', [
                'controller' => 'Hrs',
                'action' => 'editConfigSetup'
            ]);
            $routeBuilder->connect('/hrs/attendance/', [
                'controller' => 'Hrs',
                'action' => 'attendance'
            ]);
            $routeBuilder->connect('/hrs/calendar/', [
                'controller' => 'Hrs',
                'action' => 'calendar'
            ]);
            $routeBuilder->connect('/hrs/loadCalendar/*', [
                'controller' => 'Hrs',
                'action' => 'loadCalendar'
            ]);
            $routeBuilder->connect('/hrs/insertCalendar/*', [
                'controller' => 'Hrs',
                'action' => 'insertCalendar'
            ]);
            $routeBuilder->connect('/hrs/updateCalendar/*', [
                'controller' => 'Hrs',
                'action' => 'updateCalendar'
            ]);
            $routeBuilder->connect('/hrs/deleteCalendar/*', [
                'controller' => 'Hrs',
                'action' => 'deleteCalendar'
            ]);
            $routeBuilder->connect('/hrs/payroll/', [
                'controller' => 'Hrs',
                'action' => 'payroll'
            ]);
            $routeBuilder->connect('/hrs/addPayroll/', [
                'controller' => 'Hrs',
                'action' => 'addPayroll'
            ]);
            $routeBuilder->connect('/hrs/payment/*', [
                'controller' => 'Hrs',
                'action' => 'payment'
            ]);
            $routeBuilder->connect('/hrs/all_leaves/', [
                'controller' => 'Hrs',
                'action' => 'allLeaves'
            ]);
            $routeBuilder->connect('/hrs/csvAttendance/', [
                'controller' => 'Hrs',
                'action' => 'csvAttendance'
            ]);
            $routeBuilder->connect('/hrs/csvAttendanceProcess/', [
                'controller' => 'Hrs',
                'action' => 'csvAttendanceProcess'
            ]);
            $routeBuilder->connect('/hrs/leave_action/*', [
                'controller' => 'Hrs',
                'action' => 'leaveAction'
            ]);
            $routeBuilder->connect('/hrs/addLeaveAdmin/', [
                'controller' => 'Hrs',
                'action' => 'addLeaveAdmin'
            ]);
            $routeBuilder->connect('/hrs/roster/*', [
                'controller' => 'Hrs',
                'action' => 'roster'
            ]);
            $routeBuilder->connect('/hrs/addRoster/*', [
                'controller' => 'Hrs',
                'action' => 'addRoster'
            ]);
            $routeBuilder->connect('/hrs/editRoster/*', [
                'controller' => 'Hrs',
                'action' => 'editRoster'
            ]);
            $routeBuilder->connect('/hrs/monthlyAttendanceReport/', [
                'controller' => 'Hrs',
                'action' => 'monthlyAttendanceReport'
            ]);
            $routeBuilder->connect('/hrs/getLeaveAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getLeaveAjax'
            ]);

            //Route for CertificatesController @shihab
            $routeBuilder->connect('/certificates', [
                'controller' => 'certificates',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/certificates/add', [
                'controller' => 'certificates',
                'action' => 'addCertificates'
            ]);
            $routeBuilder->connect('/certificates/print/*', [
                'controller' => 'certificates',
                'action' => 'printCertificate'
            ]);
            $routeBuilder->connect('/certificates/generate/*', [
                'controller' => 'certificates',
                'action' => 'generateCertificate'
            ]);
            $routeBuilder->connect('/certificates/getConfigurationAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getConfigurationAjax'
            ]);
            $routeBuilder->connect('/certificates/view/', [
                'controller' => 'certificates',
                'action' => 'viewCertificates'
            ]);
            $routeBuilder->connect('/certificates/edit/*', [
                'controller' => 'certificates',
                'action' => 'editCertificates'
            ]);
            $routeBuilder->connect('/certificates/delete/*', [
                'controller' => 'certificates',
                'action' => 'deleteCertificates'
            ]);
            $routeBuilder->connect('/configuration', [
                'controller' => 'certificates',
                'action' => 'configCirtificates'
            ]);
            $routeBuilder->connect('/configuration/add', [
                'controller' => 'certificates',
                'action' => 'addConfig'
            ]);
            $routeBuilder->connect('/configuration/edit/*', [
                'controller' => 'certificates',
                'action' => 'editConfig'
            ]);
            $routeBuilder->connect('/configuration/tags/', [
                'controller' => 'certificates',
                'action' => 'allTags'
            ]);
            $routeBuilder->connect('/configuration/tags/add', [
                'controller' => 'certificates',
                'action' => 'addTags'
            ]);
            $routeBuilder->connect('/configuration/tags/edit/*', [
                'controller' => 'certificates',
                'action' => 'editTags'
            ]);
            $routeBuilder->connect('/configuration/types/', [
                'controller' => 'certificates',
                'action' => 'allTypes'
            ]);
            $routeBuilder->connect('/configuration/types/add', [
                'controller' => 'certificates',
                'action' => 'addTypes'
            ]);
            $routeBuilder->connect('/configuration/types/edit/*', [
                'controller' => 'certificates',
                'action' => 'editTypes'
            ]);

            //Route for LibraryController @shihab
            $routeBuilder->connect('/Library', [
                'controller' => 'Library',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/Library/books/', [
                'controller' => 'Library',
                'action' => 'books'
            ]);
            $routeBuilder->connect('/Library/add_books/', [
                'controller' => 'Library',
                'action' => 'addBooks'
            ]);
            $routeBuilder->connect('/Library/edit_books/*', [
                'controller' => 'Library',
                'action' => 'editBooks'
            ]);
            $routeBuilder->connect('/Library/delete_books/*', [
                'controller' => 'Library',
                'action' => 'deleteBooks'
            ]);
            $routeBuilder->connect('/Library/all_issue/', [
                'controller' => 'Library',
                'action' => 'allIssues'
            ]);
            $routeBuilder->connect('/Library/issue_books/', [
                'controller' => 'Library',
                'action' => 'issueBooks'
            ]);
            $routeBuilder->connect('/Library/edit_issue/*', [
                'controller' => 'Library',
                'action' => 'editIssue'
            ]);
            $routeBuilder->connect('/Library/return_books/', [
                'controller' => 'Library',
                'action' => 'returnBooks'
            ]);
            $routeBuilder->connect('/Library/return/*', [
                'controller' => 'Library',
                'action' => 'returnAction'
            ]);
            $routeBuilder->connect('/Library/members/', [
                'controller' => 'Library',
                'action' => 'members'
            ]);
            $routeBuilder->connect('/Library/add_member/', [
                'controller' => 'Library',
                'action' => 'addMember'
            ]);
            $routeBuilder->connect('/Library/edit_member/*', [
                'controller' => 'Library',
                'action' => 'editMember'
            ]);
            $routeBuilder->connect('/Gallery/view_album/', [
                'controller' => 'Album',
                'action' => 'viewAlbum'
            ]);
            $routeBuilder->connect('/Gallery/add_album/', [
                'controller' => 'Album',
                'action' => 'addAlbum'
            ]);
            $routeBuilder->connect('/Gallery/edit_album/*', [
                'controller' => 'Album',
                'action' => 'editAlbum'
            ]);
            $routeBuilder->connect('/Gallery/delete_album/*', [
                'controller' => 'Album',
                'action' => 'deleteAlbum'
            ]);
            $routeBuilder->connect('/Gallery/view_photos/', [
                'controller' => 'Photos',
                'action' => 'viewPhotos'
            ]);
            $routeBuilder->connect('/Gallery/add_photos/', [
                'controller' => 'Photos',
                'action' => 'addPhotos'
            ]);
            $routeBuilder->connect('/Gallery/edit_photos/*', [
                'controller' => 'Photos',
                'action' => 'editPhotos'
            ]);
            $routeBuilder->connect('/Gallery/delete_photos/*', [
                'controller' => 'Photos',
                'action' => 'deletePhotos'
            ]);
            //grading akash
            $routeBuilder->connect('/Gradings', [
                'controller' => 'Gradings',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/Gradings/add', [
                'controller' => 'Gradings',
                'action' => 'add'
            ]);
            $routeBuilder->connect('/Gradings/edit/*', [
                'controller' => 'Gradings',
                'action' => 'edit'
            ]);
            $routeBuilder->connect('/Gradings/edit/deleteGradeAjax/*', [
                'controller' => 'Ajax',
                'action' => 'deleteGradeAjax'
            ]);
            //result akash
            $routeBuilder->connect('/Results', [
                'controller' => 'Results',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/Results/addTemplate', [
                'controller' => 'Results',
                'action' => 'addTemplate'
            ]);
            $routeBuilder->connect('/Results/addMergeTemplate', [
                'controller' => 'Results',
                'action' => 'addMergeTemplate'
            ]);
            $routeBuilder->connect('/Results/deleteTemplate/*', [
                'controller' => 'Results',
                'action' => 'deleteTemplate'
            ]);
            $routeBuilder->connect('/Results/viewTemplate/*', [
                'controller' => 'Results',
                'action' => 'viewTemplate'
            ]);
            $routeBuilder->connect('/Results/indexTemplate', [
                'controller' => 'Results',
                'action' => 'indexTemplate'
            ]);
            $routeBuilder->connect('/Results/generateResult', [
                'controller' => 'Results',
                'action' => 'generateResult'
            ]);
            $routeBuilder->connect('/Results/generateMergeResult', [
                'controller' => 'Results',
                'action' => 'generateMergeResult'
            ]);
            $routeBuilder->connect('/Results/getSectionAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax',
            ]);
            $routeBuilder->connect('/Results/getTermAjax/*', [
                'controller' => 'Ajax',
                'action' => 'getTermAjax',
            ]);
            $routeBuilder->connect('/Results/deleteResult/*', [
                'controller' => 'Results',
                'action' => 'deleteResult',
            ]);
            $routeBuilder->connect('/Results/sendSMS/*', [
                'controller' => 'Results',
                'action' => 'sendSMS',
            ]);
            $routeBuilder->connect('/Results/publish/*', [
                'controller' => 'Results',
                'action' => 'publish',
            ]);
            $routeBuilder->connect('/Results/resultMerit/*', [
                'controller' => 'Results',
                'action' => 'resultMerit',
            ]);
            $routeBuilder->connect('/Results/view/*', [
                'controller' => 'Results',
                'action' => 'view',
            ]);
            $routeBuilder->connect('/Results/tabulationView/*', [
                'controller' => 'Results',
                'action' => 'tabulationView',
            ]);
            $routeBuilder->connect('/Results/viewResult/', [
                'controller' => 'Results',
                'action' => 'viewResult',
            ]);
            $routeBuilder->connect('/Results/viewMergeResult/', [
                'controller' => 'Results',
                'action' => 'viewMergeResult',
            ]);
            $routeBuilder->connect('/Results/mergeResult/', [
                'controller' => 'Results',
                'action' => 'mergeResult',
            ]);
            //CMS BOxes Shihab
            $routeBuilder->connect('/cms/boxes/', [
                'controller' => 'Cms',
                'action' => 'boxes'
            ]);
            $routeBuilder->connect('/cms/add_boxes/', [
                'controller' => 'Cms',
                'action' => 'addBoxes'
            ]);
            $routeBuilder->connect('/cms/edit_boxes/*', [
                'controller' => 'Cms',
                'action' => 'editBoxes'
            ]);
            $routeBuilder->connect('/cms/delete_boxes/*', [
                'controller' => 'Cms',
                'action' => 'deleteBoxes'
            ]);
            $routeBuilder->connect('/cms/page_config/', [
                'controller' => 'Cms',
                'action' => 'pageConfig'
            ]);
            $routeBuilder->connect('/cms/add_page_config/', [
                'controller' => 'Cms',
                'action' => 'addPageConfig'
            ]);
            $routeBuilder->connect('/cms/edit_page_config/*', [
                'controller' => 'Cms',
                'action' => 'editPageConfig'
            ]);
            $routeBuilder->connect('/cms/delete_page_config/*', [
                'controller' => 'Cms',
                'action' => 'deletePageConfig'
            ]);
            $routeBuilder->connect('/cms/quick_links/', [
                'controller' => 'Cms',
                'action' => 'quickLink'
            ]);
            $routeBuilder->connect('/cms/add_quick_links/', [
                'controller' => 'Cms',
                'action' => 'addQuickLink'
            ]);
            $routeBuilder->connect('/cms/edit_quick_links/*', [
                'controller' => 'Cms',
                'action' => 'editQuickLink'
            ]);
            $routeBuilder->connect('/cms/delete_quick_links/*', [
                'controller' => 'Cms',
                'action' => 'deleteQuickLink'
            ]);
            $routeBuilder->connect('/routine', [
                'controller' => 'Routine',
                'action' => 'index'
            ]);
            $routeBuilder->connect('/routine/shift', [
                'controller' => 'Routine',
                'action' => 'shift'
            ]);
            $routeBuilder->connect('/routine/add_shift/', [
                'controller' => 'Routine',
                'action' => 'addShift'
            ]);
            $routeBuilder->connect('/routine/edit_shift/*', [
                'controller' => 'Routine',
                'action' => 'editShift'
            ]);
            $routeBuilder->connect('/routine/timesheet/*', [
                'controller' => 'Routine',
                'action' => 'timesheet'
            ]);
            $routeBuilder->connect('/routine/setRoutine/', [
                'controller' => 'Routine',
                'action' => 'setRoutine'
            ]);
            $routeBuilder->connect('/routine/classRoutine/', [
                'controller' => 'Routine',
                'action' => 'classRoutine'
            ]);
            $routeBuilder->connect('/routine/getSectionAjax', [
                'controller' => 'Ajax',
                'action' => 'getSectionAjax'
            ]);
            $routeBuilder->connect('/change_status/*', [
                'controller' => 'Students',
                'action' => 'changeStatus'
            ]);
        });
    }
);
Router::plugin(
    'Croogo/Core',
    ['path' => '/'],
    function (RouteBuilder $routeBuilder) {
        $routeBuilder->setExtensions(['json']);
        $routeBuilder->applyMiddleware('csrf');

        $routeBuilder->connect('/employees/*', [
            'controller' => 'Employees',
            'action' => 'employeesList'
        ]);
        /*
              $routeBuilder->connect('/cfGetFeeInfo/', [
              'controller' => 'OnlinePayment',
              'action' => 'cfGetFeeInfo'
              ]);

              $routeBuilder->connect('/cfPaymentConfirmation/', [
              'controller' => 'OnlinePayment',
              'action' => 'cfPaymentConfirmation'
              ]);
             *
             */

        $routeBuilder->connect('/employees/profile/*', [
            'controller' => 'Employees',
            'action' => 'employeesProfile'
        ]);
        $routeBuilder->connect('/gallery/*', [
            'controller' => 'Gallery',
            'action' => 'gallery'
        ]);
        $routeBuilder->connect('/gallery/view/*', [
            'controller' => 'Gallery',
            'action' => 'viewPhotos'
        ]);
        $routeBuilder->connect('/student_dashboard', [
            'controller' => 'Students',
            'action' => 'studentDashboard'
        ]);
        $routeBuilder->connect('/student_results/*', [
            'controller' => 'Students',
            'action' => 'studentResult'
        ]);
        $routeBuilder->connect('/userLoginAjax', [
            'controller' => 'Students',
            'action' => 'userLoginAjax'
        ]);

        $routeBuilder->connect('/logout', [
            'controller' => 'Students',
            'action' => 'userLogout'
        ]);
        $routeBuilder->connect('/student_dashboard/getYearlyAttandanceAjax', [
            'controller' => 'Students',
            'action' => 'getYearlyAttandanceAjax'
        ]);
        $routeBuilder->connect('/student_dashboard/view_result/*', [
            'controller' => 'Students',
            'action' => 'viewResult'
        ]);
        $routeBuilder->connect('/student_dashboard/print_recipt/*', [
            'controller' => 'Students',
            'action' => 'printRecipt'
        ]);
        $routeBuilder->connect('/student_dashboard/pay_now/*', [
            'controller' => 'Students',
            'action' => 'payNow'
        ]);
        $routeBuilder->connect('/tform/*', [
            'controller' => 'Admission',
            'action' => 'tform'
        ]);
        $routeBuilder->connect('/index/*', [
            'controller' => 'Admission',
            'action' => 'index'
        ]);
        // $routeBuilder->connect('/admissionform/*', [
        //     'controller' => 'Admission',
        //     'action' => 'admissionform'
        // ]);
        $routeBuilder->connect('/upload/*', [
            'controller' => 'Admission',
            'action' => 'upload'
        ]);
        $routeBuilder->connect('/payment/*', [
            'controller' => 'Admission',
            'action' => 'payment'
        ]);
        $routeBuilder->connect('/admitcard', [
            'controller' => 'Admission',
            'action' => 'admitcard'
        ]);
        $routeBuilder->connect('/admit_search', [
            'controller' => 'Admission',
            'action' => 'admitSearch'
        ]);
        $routeBuilder->connect('/search_student/*', [
            'controller' => 'Search',
            'action' => 'searchStudent'
        ]);
        $routeBuilder->connect('/sid_search/*', [
            'controller' => 'Search',
            'action' => 'sidSearch'
        ]);
        $routeBuilder->connect('/two_taka_search/*', [
            'controller' => 'Search',
            'action' => 'twoTakaSearch'
        ]);
        $routeBuilder->connect('/Ajax/getCodeAjax', [
            'controller' => 'Ajax',
            'action' => 'getCodeAjax'
        ]);
        $routeBuilder->connect('/Ajax/getSubjectAjax', [
            'controller' => 'Ajax',
            'action' => 'getSubjectAjax'
        ]);
        $routeBuilder->connect('/Ajax/getReligionSubjectAjax', [
            'controller' => 'Ajax',
            'action' => 'getReligionSubjectAjax'
        ]);
        $routeBuilder->connect('/Ajax/getSectionAjax', [
            'controller' => 'Ajax',
            'action' => 'getSectionAjax'
        ]);
        $routeBuilder->connect('/Ajax/getLevelSectionAjax', [
            'controller' => 'Ajax',
            'action' => 'getLevelSectionAjax'
        ]);
        $routeBuilder->connect('/departments', [
            'controller' => 'Departments',
            'action' => 'index'
        ]);
        $routeBuilder->connect('/employee_profile/*', [
            'controller' => 'Departments',
            'action' => 'employeesProfile'
        ]);
        $routeBuilder->connect('/administration/*', [
            'controller' => 'Departments',
            'action' => 'administration'
        ]);
        $routeBuilder->connect('/getEmployeesAjax/*', [
            'controller' => 'Departments',
            'action' => 'getEmployeesAjax'
        ]);
        $routeBuilder->connect('/login', [
            'controller' => 'Students',
            'action' => 'loginForm'
        ]);
    }
);
