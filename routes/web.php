<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Seat;

use App\Http\Controllers\HostelController;
use App\Http\Controllers\WardenController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotiMasterController;
use App\Http\Controllers\AllotmentController;
use App\Http\Controllers\AllotHostelController;
use App\Http\Controllers\AllotSeatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\PersonRemarkController;
use App\Http\Controllers\PersonRemarkDetailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessnController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\HostelAdmissionController;
use App\Http\Controllers\CancelSeatController;
use App\Http\Controllers\CancelHostelController;
use App\Http\Controllers\ConsolidateController;
use App\Http\Controllers\ClearanceController;
use App\Http\Controllers\FeedbackMasterController;
use App\Http\Controllers\FeedbackCriteriaController;
use App\Http\Controllers\FeedbackOptionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationManageController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SemAllotController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\diktei\ZirlaiController;
use App\Http\Controllers\AntiragController;
use App\Http\Controllers\SectionController;

use App\Http\Controllers\CourseController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

Route::get('/testing', function () {
    return \App\Models\Lib::rand(5);
});
Route::get('/welcome', function () {
    return view('welcome2');
});
Route::get('/bt', function () {
    return view('test.bt');
});
Route::get('/reshuffledata', [App\Http\Controllers\DikteiController::class, 'reshuffledata']);

Route::get('/test', [App\Http\Controllers\PdfController::class, 'download']);


Route::get('/', function () {
    return view('home');
});

Route::post('/fb/temp/action', [FeedbackController::class, 'action']);
// Route::controller(App\Models\FeedbackController::class)->group(function(){
//     Route::post('/fb/temp/action', 'action')->middleware(['auth']);
// });

Route::get('/message', [MessageController::class, 'index']);
Route::get('/warden', [WardenController::class, 'list']);
Route::get('/search', [SearchController::class, 'index'])->middleware(['auth']);
Route::get('/consolidate', [ConsolidateController::class, 'index'])->middleware(['dsw']);
Route::get('/consolidateDetail', [ConsolidateController::class, 'detail'])->middleware(['dsw']);
Route::post('/consolidate', [ConsolidateController::class, 'store'])->middleware(['dsw']);
// Route::get('/admissioncheck', [AdmissionCheckController::class, 'check']);
// Route::post('/admissioncheck', [AdmissionCheckController::class, 'checkStore']);
Route::post('/allotment/{id}/admission_decline', [AdmissionController::class, 'admission_decline']);
// Route::get('/allotment/{id}/admission', [AdmissionCheckController::class, 'index']);
Route::get('/feedbackMaster/{id}/report', [FeedbackMasterController::class, 'report'])->middleware(['auth']);
Route::get('/feedbackCriteria/{id}/report-string', [FeedbackCriteriaController::class, 'report_string'])->middleware(['auth']);
Route::get('/clearance/search', [ClearanceController::class, 'search']);
Route::get('/clearance/{id}/view', [ClearanceController::class, 'show']);
Route::get('/clearance/{id}/download', [ClearanceController::class, 'download']);
Route::get('/application/search', [ApplicationController::class, 'search']);
Route::post('/application/search', [ApplicationController::class, 'searchStore']);
Route::put('/application/{id}/statusUpdate', [ApplicationController::class, 'statusUpdate'])->middleware('auth');
Route::get('/application/list', [ApplicationController::class, 'list'])->middleware('auth');
Route::get('/application/approved', [ApplicationController::class, 'approved'])->middleware('auth');
Route::post('/application/approved', [ApplicationController::class, 'notify'])->middleware('auth');
Route::get('/application/notified', [ApplicationController::class, 'notified'])->middleware('auth');
Route::get('/application/summary', [ApplicationController::class, 'summary'])->middleware('auth');
Route::get('/application/summary-hostel', [ApplicationController::class, 'summary_hostel'])->middleware('auth');
Route::get('/application/priority-list', [ApplicationController::class, 'priority_list'])->middleware('auth');
Route::post('/application/navigate', [ApplicationController::class, 'navigate'])->middleware('auth');
Route::post('/notiMaster/addToNotiMaster', [NotiMasterController::class, 'addToNotiMaster'])->middleware('auth');
Route::post('/sop/fileupload', [SopController::class, 'fileupload']);
Route::post('/noti_master/fileupload', [NotiMasterController::class, 'fileupload']);
// Route::post('/application/navigate', function(){
//     return "Hello";
// })->middleware('auth');
Route::get('/application/{id}/duplicate', [ApplicationController::class, 'duplicate'])->middleware('auth');
Route::get('/duplicate/application', [ApplicationController::class, 'duplicates'])->middleware('auth');



Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'logincheck']);
Route::get('/user/{id}/changePassword', [UserController::class, 'changePassword'])->middleware('auth');
Route::post('/user/{id}/changePassword', [UserController::class, 'changePasswordStore']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/hostel/{hostel}/occupants', [HostelController::class, 'occupants'])->middleware('auth');
Route::get('/hostel/{hostel}/requirement', [HostelController::class, 'requirement'])->middleware('auth');
Route::get('/hostel/{hostel}/requirement_list', [HostelController::class, 'requirementList'])->middleware('auth');
Route::post('/hostel/{hostel}/requirement_list', [HostelController::class, 'requirementListUpdate'])->middleware('auth');
Route::get('/hostel/{hostel}/requirement_notify', [HostelController::class, 'requirementNotify'])->middleware('auth');
Route::post('/hostel/{hostel}/requirement_notify', [HostelController::class, 'requirementNotifyUpdate'])->middleware('auth');
Route::post('/allotment/{allotment}/clear_allotment', [AllotmentController::class, 'clear_allotment'])->middleware('auth');
Route::get('/notification/{id}/printable', [NotificationController::class, 'printable'])->middleware('auth');
Route::get('/requirement/summary', [RequirementController::class, 'summary'])->middleware('auth');
Route::get('/notification/check', [NotificationController::class, 'check']);
Route::post('/notification/check', [NotificationController::class, 'checkStore']);
Route::resource('application', ApplicationController::class);


Route::resource('person', PersonController::class)->middleware('auth');
Route::resource('person.student', StudentController::class)->shallow()->middleware('auth');
Route::resource('person.other', OtherController::class)->shallow()->middleware('auth');
Route::resource('person.person_remark', PersonRemarkController::class)->shallow()->middleware('auth');
Route::resource('person_remark.person_remark_detail', PersonRemarkDetailController::class)->shallow()->middleware('auth');
Route::resource('hostel', HostelController::class);
Route::resource('hostel.room', RoomController::class)->shallow()->middleware('auth');
Route::resource('cancelSeat.clearance', ClearanceController::class)->shallow()->middleware('auth')->except(['show']);
Route::resource('hostel.cancelHostel', CancelHostelController::class)->shallow()->middleware('auth');
Route::resource('hostel.warden', WardenController::class)->shallow()->middleware(['auth', 'dsw']);
Route::resource('hostel.admission', HostelAdmissionController::class)->only(['index'])->shallow()->middleware('auth');

Route::resource('room.seat', SeatController::class)->shallow()->middleware('auth');
Route::resource('notiMaster', NotiMasterController::class);
Route::resource('notiMaster.notification', NotificationController::class)->middleware('auth')->shallow();
Route::resource('notification.allotment', AllotmentController::class)->shallow()->middleware('auth');
Route::resource('notification.sem_allot', SemAllotController::class)->shallow()->middleware('auth');
Route::resource('allotment.admission', AdmissionController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->shallow()->middleware('auth');
Route::resource('allotment.allot_hostel', AllotHostelController::class)->shallow()->middleware('auth');
Route::resource('allotment.cancelSeat', CancelSeatController::class)->shallow()->middleware('auth');
Route::resource('allotment.requirement', RequirementController::class)->shallow()->only(['index', 'create', 'store'])->middleware('auth');
Route::resource('user', UserController::class)->middleware(['auth']);
Route::resource('sop', SopController::class)->middleware(['auth']);

Route::resource('feedbackMaster', FeedbackMasterController::class)->middleware(['auth']);
Route::resource('feedbackMaster.criteria', FeedbackCriteriaController::class)->shallow()->only(['index', 'create', 'store'])->middleware(['auth']);
Route::resource('feedbackMaster.feedback', FeedbackController::class)->shallow()->only(['index', 'create', 'store'])->middleware(['auth']);
Route::resource('feedbackCriteria', FeedbackCriteriaController::class)->except(['index', 'create', 'store'])->middleware(['auth']);
Route::resource('feedbackCriteria.option', FeedbackOptionController::class)->shallow()->only(['index', 'create', 'store'])->middleware(['auth']);
// Route::resource('feedbackMaster.criteria', FeedbackCriteriaController::class)->shallow()->middleware(['auth']);
Route::resource('feedback', FeedbackController::class)->middleware(['auth']);
// Route::resource('course', CourseController::class)->middleware('auth');
Route::resource('antirag', AntiragController::class)->middleware('auth');
Route::resource('section', SectionController::class);

Route::resource('sessn', SessnController::class)->middleware(['auth']);

Route::get('/allot_hostel/{id}/allotSeat', [AllotSeatController::class, 'allotSeat'])->middleware('auth');
Route::post('/allot_hostel/{id}/allotSeat', [AllotSeatController::class, 'allotSeatStore']);

Route::get('/seat/{id}/allotSeat', [SeatController::class, 'allotSeat'])->middleware('auth');
Route::post('/seat/{id}/allotSeat', [SeatController::class, 'allotSeatStore']);

Route::post('/room/{id}/unavailable', [RoomController::class, 'unavailable'])->middleware('auth');
Route::get('/room/{id}/editseatavailability', [RoomController::class, 'editseatavailability'])->middleware('auth');
Route::post('/room/{id}/editseatavailability', [RoomController::class, 'updateseatavailability']);
Route::get('/room/{id}/remark', [RoomController::class, 'remark'])->middleware('auth');
Route::post('/room/{id}/remark', [RoomController::class, 'remarkStore']);
Route::get('/seat/{id}/remark', [SeatController::class, 'remark'])->middleware('auth');
Route::post('/seat/{id}/remark', [SeatController::class, 'remarkStore']);
Route::delete('/room/remark/{id}', [RoomController::class, 'remarkDelete']);

Route::get('/person/{id}/confirm_delete', [PersonController::class, 'delete'])->middleware('auth');

Route::controller(App\Http\Controllers\StudentRegistrationController::class)->group(function () {
    Route::get('/studentRegistration', 'registration');
    Route::post('/studentRegistration', 'registrationStore');
    Route::get('/studentRegistration/create_user', 'create_user');
    Route::post('/studentRegistration/create_user_store', 'create_user_store');
});

Route::controller(RequirementController::class)->group(function () {
    Route::get('/requirement/list', 'list');
    Route::post('/requirement/list', 'listUpdate');
    Route::get('/requirement/{id}/duplicate', 'duplicate');
});



Route::controller(App\Http\Controllers\AjaxController::class)->group(function () {
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



Route::controller(App\Http\Controllers\DikteiController::class)->group(function () {
    Route::get('/diktei/', 'index');
    Route::get('/diktei/course', 'course')->middleware(['auth']);
    Route::get('/diktei/course/{id}', 'course_show');
    Route::get('/diktei/entry', 'entry');
    Route::get('/diktei/option', 'option');
    Route::get('/diktei/no-submission', 'no_submission');
    Route::get('/diktei/partial-submission', 'partial_submission');

    Route::post('/diktei/submit', 'submit');
    Route::get('/diktei/dtallot', 'subject_allotments');
    Route::post('/diktei/dtallot', 'allot_subjects');
    Route::post('/diktei/clearOptions', 'clear_options');
});

Route::controller(\App\Http\Controllers\SemfeeController::class)->group(function () {
    Route::get('/semfee/', 'index')->middleware(['auth']);
    Route::post('/hostel/{id}/semfee/approveall', 'approveAll')->middleware(['auth']);
    Route::post('/hostel/{id}/semfee/confirmall', 'confirmAll')->middleware(['auth']);
    Route::post('/hostel/{id}/semfee/sendall', 'sendAll')->middleware(['auth']);
    Route::get('/allot_hostel/{id}/semfee/create', 'create')->middleware(['auth']);
    Route::post('/allot_hostel/{id}/semfee', 'store')->middleware(['auth']);
    Route::get('/semfee/list/hostel/{id?}/{status?}', 'list')->middleware(['auth']);
    Route::post('/semfee/{id}/paymentUpdate', 'paymentUpdate')->middleware(['auth']);
});

Route::controller(\App\Http\Controllers\FinanceController::class)->group(function () {
    Route::get('/finance/', 'index')->middleware(['auth']);
});

Route::controller(FeedbackController::class)->group(function () {
    Route::post('/feedback/temp/action', 'action')->middleware(['auth']);
});

Route::resource('zirlai', ZirlaiController::class)->middleware('auth')->shallow();











Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';
require __DIR__ . '/mass.php';
require __DIR__ . '/test.php';
