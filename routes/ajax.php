<?php

use App\Http\Controllers\AjaxController;

Route::controller(AjaxController::class)->group(function () {
    Route::get('/ajaxroom/{id}/seat', 'getSeats');
    Route::get('/ajax/hostel/{id}/allot_hostel', 'getAllotHostels');
    Route::get('/ajax/get_available_seats', 'get_available_seats');
    Route::get('/ajax/get_all_seats', 'get_all_seats');
    Route::get('/ajax/get_role/{id}', 'get_role');
    Route::post('/ajax/allot_seat_store', 'allotSeatStore');
    Route::post('/ajax/seat/{id}/deallocate', 'deallocateSeat');
    Route::post('/ajax/manage_admission', 'manage_admission');
    Route::get('/ajax/feedback_criteria/{id}/report_chart', 'report_chart');
    Route::post('/ajax/application/{id}/decline', 'declineApplication');
    Route::post('/ajax/application/{id}/delete', 'deleteApplication');
    Route::post('/ajax/application/{id}/accept', 'acceptApplication');
    Route::post('/ajax/application/{id}/remark', 'remarkApplication');
    Route::get('/ajax/getCourses', 'getCourses');
    Route::get('/ajax/getMaxSem', 'getMaxSem');
    Route::post('/ajax/notification/{id}/reserial', 'reserialNotification');
    Route::post('/ajax/application/status_update', 'applicationStatusUpdate');
    Route::post('/ajax/requirement/{id}/delete', 'requirementDelete');
    Route::post('/ajax/allotment/{id}/allot_hostel/store', 'createAllotHostel');
    Route::post('/ajax/allotment/{id}/admission/store', 'createAdmission');
    Route::post('/ajax/admission/{id}/update', 'updateAdmission');
    Route::post('/ajax/admission/{id}/verify', 'verifyAdmission');
    Route::post('/ajax/admission/{id}/undo-verify', 'undoVerifyAdmission');
    Route::post('/ajax/admission/{id}/delete', 'deleteAdmission');
    Route::get('/ajax/allotment/{id}/application', 'getApplication');
    Route::post('/ajax/allotment/{id}/decline', 'declineAllotment');
    Route::get('/ajax/notiMaster/{id}/getNotifications', 'getNotifications');

    Route::post('/ajax/course/{id}/addStudent', 'addStudent');
    Route::get('/ajax/zirlai/{id}/getZirlai', 'getZirlai');
    Route::post('/ajax/zirlai/{id}/delete', 'deleteZirlai');

    Route::post('/ajax/course/{id}/addSubject', 'addSubject');
    Route::get('/ajax/subject/{id}/getSubject', 'getSubject');
    Route::post('/ajax/subject/{id}/delete', 'deleteSubject');
    Route::get('/ajax/diktei/subjects', 'getSubjects');

    Route::get('/ajax/person/{id}/getEmail', 'getEmail');
    Route::post('/ajax/person/{id}/updateEmail', 'updateEmail');

    Route::get('/ajax/semfee/{id}/getDetail', 'getSemfeeDetail');
    Route::post('/ajax/semfee/{id}/updateStatus', 'updateSemfeeStatus');
    Route::post('/ajax/semfee/{id}/updatePayment', 'updateSemfeePayment');
    Route::get('/ajax/semfee/{id}/paymentDetail', 'semfeePaymentDetail');
})->middleware('auth');

