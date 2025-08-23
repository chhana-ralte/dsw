<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function getSeats($room_id)
    {
        $seats = \App\Models\Seat::where('room_id', $room_id)->orderBy('serial')->get();
        return $seats;
    }

    public function get_role($id)
    {
        return \App\Models\Role::find($id);
    }

    public function allotSeatStore()
    {
        \App\Models\AllotSeat::where('seat_id', request()->seat_id)
            ->where('valid', 1)
            ->update([
                'valid' => 0,
                'to_dt' => date('Y-m-d'),
                'leave_dt' => date('Y-m-d')
            ]);

        \App\Models\AllotSeat::where('allot_hostel_id', request()->allot_hostel_id)
            ->where('valid', 1)
            ->update([
                'valid' => 0,
                'to_dt' => date('Y-m-d'),
                'leave_dt' => date('Y-m-d')
            ]);

        $allot_hostel = \App\Models\AllotHostel::findOrFail(request()->allot_hostel_id);

        \App\Models\AllotSeat::create([
            'allot_hostel_id' => $allot_hostel->id,
            'seat_id' => request()->seat_id,
            'from_dt' => date('Y-m-d'),
            'to_dt' => $allot_hostel->to_dt,
            'valid' => 1
        ]);

        return "Success";
    }

    public function deallocateSeat($seat_id)
    {
        //return $seat_id;
        \App\Models\AllotSeat::where('seat_id', $seat_id)->where('valid', 1)->update([
            'valid' => 0,
            'leave_dt' => date('Y-m-d'),
            'to_dt' => date('Y-m-d')
        ]);
        return "Success";
    }

    public function getAllotHostels($hostel_id)
    {
        $search = $_GET['search'];
        $data = DB::table('people')->join('allotments', 'people.id', '=', 'allotments.person_id')
            ->join('allot_hostels', 'allotments.id', '=', 'allot_hostels.allotment_id')
            ->select('allot_hostels.id', 'people.name', 'people.address')
            ->where('allot_hostels.hostel_id', $hostel_id)
            ->where('allot_hostels.valid', 1)
            ->whereLike('name', '%' . $search . '%')
            ->get();

        //$data = \App\Models\Person::whereLike('name','%' . $search . '%')->get();
        return $data;
    }

    public function get_available_seats()
    {
        // return [['id' => 1, 'roomno' => "D-3", 'serial' => "5", 'room_id' =>'5']];
        if (isset($_GET['hostel_id'])) {
            $hostel = \App\Models\Hostel::findOrFail($_GET['hostel_id']);
            $seats = $hostel->get_available_seats('array');
            return $seats;
        }
        return false;





        if (isset($_GET['hostel_id'])) {
            $hostel = \App\Models\Hostel::findOrFail($_GET['hostel_id']);
            $room_ids = \App\Models\Room::where('hostel_id', $hostel->id)->pluck('id');
            $seat_ids = \App\Models\Seat::whereIn('room_id', $room_ids)->pluck('id');
        } else if (isset($_GET['room_id'])) {
            $room = \App\Models\Room::findOrFail($_GET['room_id']);
            $room_ids = [$room->id];
            $seat_ids = \App\Models\Seat::where('room_id', $room->id)->pluck('id');
        } else {
            return false;
        }


        //return $seat_ids;
        $occupied_seat_ids = \App\Models\AllotSeat::whereIn('seat_id', $seat_ids)->where('valid', 1)->pluck('seat_id');

        $available_seat_ids = \App\Models\Seat::where('available', '<>', 0)->whereIn('room_id', $room_ids)->whereNotIn('id', $occupied_seat_ids)->pluck('id');
        //return $available_seat_ids;
        $seats = DB::table('seats')->join('rooms', 'seats.room_id', 'rooms.id')
            ->select('seats.id', 'rooms.roomno', 'rooms.id as room_id', 'seats.serial', '')
            ->whereIn('seats.id', $available_seat_ids)
            ->get();

        return $seats;
    }

    public function get_all_seats()
    {

        if (isset($_GET['hostel_id'])) {
            $hostel = \App\Models\Hostel::findOrFail($_GET['hostel_id']);
            $seats = $hostel->get_all_seats('array');
            return $seats;
        }
        return false;


        if ($isset($_GET['hostel_id'])) {
            $hostel = \App\Models\Hostel::findOrFail($_GET['hostel_id']);
            return $hostel->get_all_seats();
        }

        if (isset($_GET['hostel_id'])) {
            $seats = DB::table('seats')->join('rooms', 'seats.room_id', 'rooms.id')
                ->select('seats.id', 'rooms.roomno', 'rooms.id as room_id', 'seats.serial')
                ->where('rooms.hostel_id', $_GET['hostel_id'])
                ->get();
            return $seats;
        } else if (isset($_GET['room_id'])) {
            $seats = DB::table('seats')->join('rooms', 'seats.room_id', 'rooms.id')
                ->select('seats.id', 'rooms.roomno', 'rooms.id as room_id', 'seats.serial')
                ->where('rooms.id', $_GET['room_id'])
                ->get();
            return $seats;
        } else {
            return false;
        }


        //return $seat_ids;
        $occupied_seat_ids = \App\Models\AllotSeat::whereIn('seat_id', $seat_ids)->where('valid', 1)->pluck('seat_id');

        $available_seat_ids = \App\Models\Seat::whereIn('room_id', $room_ids)->whereNotIn('id', $occupied_seat_ids)->pluck('id');
        //return $available_seat_ids;
        $seats = DB::table('seats')->join('rooms', 'seats.room_id', 'rooms.id')
            ->select('seats.id', 'rooms.roomno', 'rooms.id as room_id', 'seats.serial')
            ->whereIn('seats.id', $available_seat_ids)
            ->get();
        return $seats;
    }

    public function deleteAdmission($id)
    {
        // return $id;
        // return request()->undo;
        \App\Models\Admission::find($id)->delete();
        return "Successful";

        $allot_hostel = \App\Models\AllotHostel::findOrFail(request()->allot_hostel_id);
        \App\Models\Admission::where('allot_hostel_id', $allot_hostel->id)
            ->where('sessn_id', request()->sessn_id)
            ->delete();
    }

    public function report_chart($feedback_criteria_id)
    {
        $feedback_criteria = \App\Models\FeedbackCriteria::findOrFail($feedback_criteria_id);
        if ($feedback_criteria->type == 'Rating') {
            $labels = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            $data = [];
            foreach ($labels as $label) {
                array_push($data, \App\Models\FeedbackDetail::where('feedback_criteria_id', $feedback_criteria->id)->where('value', $label)->count());
            }
        } else if ($feedback_criteria->type == 'Multiple choice') {
            $options = \App\Models\FeedbackOption::where('feedback_criteria_id', $feedback_criteria->id)->get();
            $labels = [];
            $data = [];
            foreach ($options as $opt) {
                array_push($labels, $opt->option);
                array_push($data, \App\Models\FeedbackDetail::where('feedback_criteria_id', $feedback_criteria->id)->where('value', $opt->id)->count());
            }
        }
        $data = [
            'labels' => $labels,
            'data' => $data,
        ];
        return $data;
        // return "this:" . $feedback_criteria_id;
    }

    public function acceptApplication($id)
    {
        return $id;
    }

    public function getCourses()
    {
        // return "Hello";
        if (request()->has('department')) {
            // return request()->department;
            $department = \App\Models\Department::where('id', $_GET['department'])->first();
            $courses = \App\Models\Course::where('department_id', $department->id)->get();
            return $courses;
        }
        return "Error";
    }

    public function getMaxSem()
    {
        // return "Hello";
        if (request()->has('course')) {
            // return request()->department;
            $course = \App\Models\Course::where('id', $_GET['course'])->first();
            // return $course->max_semester;
            return ['max_sem' => $course->max_semester];
        }
        return "Error";
    }

    public function remarkApplication($id)
    {
        $application = \App\Models\Application::findOrFail($id);
        $application->remark = request()->remark;
        $application->save();
        return "Success";
    }

    public function reserialNotification($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);
        if ($notification->type == "sem_allot") {
            // $sem_allots = $notification->sem_allots->orderBy('sl')->get();
            $sem_allots = \App\Models\SemAllot::where('notification_id', $notification->id)->orderBy('sl')->orderBy('id')->get();
            $sl = 1;
            foreach ($sem_allots as $sa) {
                $sa->update([
                    'sl' => $sl++,
                ]);
                $sa->save();
            }
        } else if ($notification->type == "allotment") {
            $allotments = \App\Models\Allotment::where('notification_id', $notification->id)->orderBy('sl')->orderBy('id')->get();
            $sl = 1;
            foreach ($allotments as $allot) {
                $allot->update([
                    'sl' => $sl++,
                ]);
                $allot->save();
            }
        }
        return "Success";
    }
    public function applicationStatusUpdate()
    {
        \App\Models\Application::statusUpdate(request()->status);
        return \App\Models\Application::status();
    }

    public function deleteApplication($id)
    {
        // return "Hjasdhfjsdf";
        $next = DB::select("SELECT min(id) AS id FROM applications WHERE id > " . $id);
        if (!$next) {
            $next = DB::select("SELECT max(id) AS id FROM applications WHERE id < " . $id);
        }
        // return $next[0]->id;
        \App\Models\Application::destroy($id);
        return ['message' => "Success", "id" => $next[0]->id];
    }

    public function requirementDelete($id)
    {
        \App\Models\Requirement::destroy($id);
        return "Success";
    }

    public function createAllotHostel($id)
    {
        // return $id;
        $allotment = \App\Models\Allotment::findOrFail($id);
        $seat = \App\Models\Seat::findOrFail(request()->seat);

        $allot_hostel = \App\Models\AllotHostel::updateOrCreate(
            [
                'allotment_id' => $allotment->id,
                'hostel_id' => $allotment->hostel->id,
                'valid' => 1,
            ],
            [
                'allotment_id' => $allotment->id,
                'hostel_id' => $allotment->hostel->id,
                'valid' => 1,
                'from_dt' => $allotment->from_dt,
                'to_dt' => $allotment->to_dt,
            ]
        );

        \App\Models\AllotSeat::where('seat_id', request()->seat)->where('valid', 1)->update(['valid' => 0]);

        \App\Models\AllotSeat::where('allot_hostel_id', $allot_hostel->id)->where('valid', 1)->update(['valid' => 0]);

        $allot_seat = \App\Models\AllotSeat::updateOrCreate(
            [
                'allot_hostel_id' => $allot_hostel->id,
                'seat_id' => $seat->id,
            ],
            [
                'allot_hostel_id' => $allot_hostel->id,
                'seat_id' => $seat->id,
                'valid' => 1,
                'from_dt' => $allot_hostel->from_dt,
                'to_dt' => $allot_hostel->to_dt,
            ]
        );
    }

    public function createAdmission($id)
    {

        $allotment = \App\Models\Allotment::findOrFail($id);


        if ($allotment->valid_allot_hostel()) {
            if ($allotment->start_sessn_id == request()->sessn_id) {
                $detail = "New admission payment";
            } else {
                $detail = "Semester admission payment";
            }
            \App\Models\Admission::updateOrCreate(
                [
                    'allotment_id' => $allotment->id,
                    'sessn_id' => request()->sessn_id,
                    'allot_hostel_id' => $allotment->valid_allot_hostel()->id,
                ],
                [
                    'allotment_id' => $allotment->id,
                    'sessn_id' => request()->sessn_id,
                    'allot_hostel_id' => $allotment->valid_allot_hostel()->id,
                    'amount' => request()->amount,
                    'payment_dt' => request()->payment_dt,
                    'detail' => $detail,
                ]
            );

            $allotment->update([
                'admitted' => 1,
                'confirmed' => 1,
                'valid' => 1,
            ]);
            $allotment->save();
            return "Successful";
        } else {
            return "Valid allotment of seat is required";
        }
    }

    public function getApplication($allotment_id)
    {
        // return "Here: " . $allotment_id;
        $allotment = \App\Models\Allotment::find($allotment_id);
        if ($allotment->application) {
            return ['remark' => $allotment->application->remark];
        } else {
            return ['remark' => ''];
        }
    }

    public function declineAllotment($allotment_id)
    {
        $allotment = \App\Models\Allotment::find($allotment_id);
        $application = $allotment->application;
        if ($application) {
            $application->update([
                'remark' => request()->remark,
                'valid' => 0,
            ]);
            $application->save();
            \App\Models\Remark::create([
                'type' => 'applications',
                'foreign_id' => $application->id,
                'remark' => 'Application declined',
            ]);
        }
        $allotment->update([
            'valid' => 0,
            'admitted' => 0,
            'confirmed' => 0,
        ]);


        $allotment->save();

        $allot_hostels = $allotment->allot_hostels;

        if (count($allot_hostels) > 0) {
            \App\Models\AllotSeat::whereIn('allot_hostel_id', $allot_hostels->pluck('id'))->delete();
        }

        \App\Models\AllotHostel::whereIn('id', $allot_hostels->pluck('id'))->delete();

        \App\Models\Remark::create([
            'type' => 'allotments',
            'foreign_id' => $allotment->id,
            'remark' => request()->remark,
        ]);
        return "Successfully declined";
    }

    public function getNotifications($noti_master_id)
    {
        return \App\Models\Notification::where('noti_master_id', $noti_master_id)->where('status', 'active')->get();
    }

    public function addStudent($course_id)
    {
        if (request()->zirlai_id == 0) {
            \App\Models\Zirlai::create([
                'mzuid' => request()->mzuid,
                'rollno' => request()->rollno,
                'name' => request()->name,
                'course_id' => $course_id,

            ]);
        } else {
            \App\Models\Zirlai::where('id', request()->zirlai_id)
                ->update([
                    'name' => request()->name,
                    'rollno' => request()->rollno,
                    'mzuid' => request()->mzuid,
                    'course_id' => $course_id,
                ]);
        }
        return "Successful";
    }



    public function getZirlai($zirlai_id)
    {
        return \App\Models\Zirlai::find($zirlai_id);
    }

    public function deleteZirlai($zirlai_id)
    {
        \App\Models\Zirlai::find($zirlai_id)->delete();
        return "Deleted";
    }

    public function addSubject($course_id)
    {
        if (request()->subject_id == 0) {
            \App\Models\Subject::create([
                'code' => request()->code,
                'type' => request()->type,
                'name' => request()->name,
                'capacity' => request()->capacity,
                'course_id' => $course_id,

            ]);
        } else {
            \App\Models\Subject::where('id', request()->subject_id)
                ->update([
                    'name' => request()->name,
                    'code' => request()->code,
                    'type' => request()->type,
                    'capacity' => request()->capacity,
                    'course_id' => $course_id,
                ]);
        }
        return "Successful";
    }
    public function getSubject($subject_id)
    {
        return \App\Models\Subject::find($subject_id);
    }
    public function deleteSubject($subject_id)
    {
        \App\Models\Subject::find($subject_id)->delete();
        return "Deleted";
    }

    public function getSubjects()
    {
        // return request()->str;
        $arr = explode(',', request()->str);
        $zirlai = \App\Models\Zirlai::find(request()->zirlai_id);
        return \App\Models\Subject::whereNotIn('id', $arr)->where('course_id','<>',$zirlai->course_id)->orderBy('code')->get();
    }
}
