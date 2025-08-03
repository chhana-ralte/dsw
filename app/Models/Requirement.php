<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requirement extends Model
{
    protected $guarded = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function allotment()
    {

        return Allotment::where('id', $this->allot_hostel->allotment_id)->first();
    }

    public function allot_hostel()
    {
        return $this->belongsTo(AllotHostel::class);
    }

    public function for_sessn()
    {
        return Sessn::where('id', $this->for_sessn_id)->first();
    }
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
    public function new_hostel()
    {
        return $this->belongsTo(Hostel::class, 'new_hostel_id');
    }

    public function roomType()
    {
        return $this->roomcapacity == 1 ? 'Single' : ($this->roomcapacity == 2 ? 'Double' : ($this->roomcapacity == '3' ? 'Triple' : 'Dormitory'));
    }
    public function new_roomType()
    {
        return $this->new_roomcapacity == 1 ? 'Single' : ($this->new_roomcapacity == 2 ? 'Double' : ($this->new_roomcapacity == '3' ? 'Triple' : 'Dormitory'));
    }

    public static function nothing($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            $valid_allot_hostels = DB::select("SELECT allot_hostels.id
                FROM allot_hostels JOIN allotments ON allotments.id=allot_hostels.allotment_id AND allotments.valid = 1
                WHERE allot_hostels.valid = 1
                AND (allotments.start_sessn_id <> '". Sessn::current()->id ."' OR allotments.start_sessn_id IS NULL)
                AND allot_hostels.allotment_id NOT IN (SELECT allotment_id FROM requirements)
                ");
            $valid_allot_hostels = AllotHostel::hydrate($valid_allot_hostels);

            return AllotHostel::whereIn('id', $valid_allot_hostels->pluck('id'));


            $requirements = Requirement::where('id', '>', 0);
            $allotments = DB::select("SELECT allotments.id
                FROM requirements JOIN allotments ON requirements.allotment_id = allotments.id AND allotments.valid = 1
                WHERE (allotments.start_sessn_id IS NULL OR allotments.start_sessn_id <> '" . Sessn::current()->id . "')");

            $allotments = Allotment::hydrate($allotments);

            return AllotHostel::where('valid', 1)->whereNotIn('allotment_id', $allotments->pluck('id'));
        } else {
            $valid_allot_hostels = DB::select("SELECT allot_hostels.id
                FROM allot_hostels JOIN allotments ON allotments.id=allot_hostels.allotment_id AND allotments.valid = 1
                WHERE allot_hostels.valid = 1 AND allot_hostels.hostel_id = '". $hostel_id ."'
                AND (allotments.start_sessn_id <> '". Sessn::current()->id ."' OR allotments.start_sessn_id IS NULL)
                AND allot_hostels.allotment_id NOT IN (SELECT allotment_id FROM requirements)
                ");
            $valid_allot_hostels = AllotHostel::hydrate($valid_allot_hostels);

            return AllotHostel::whereIn('id', $valid_allot_hostels->pluck('id'));

            $allotments = Allotment::where('valid', 1)->where('start_sessn_id', '<>', Sessn::current()->id)->whereNotNull('start_sessn_id');
            $allotments = DB::select("SELECT ");
            $requirements = Requirement::where('id', '>', 0);
            return AllotHostel::where('valid', 1)->where('hostel_id', $hostel_id)->whereIn('allotment_id', $requirements->pluck('allotment_id'));
            AllotHostel::join('allotments', 'allotments.id', '=', 'allot_hostels.allotment_id')
                ->join('requirements', 'allotments.id', 'requirements.allotment_id')
                ->where('allotments.valid', 1)
                ->where('allot_hostels.valid', 1)
                ->where('allot_hostels.hostel_id', $hostel_id);

        }

        $allotments = Allotment::where('start_sessn_id', Sessn::current()->id)->where('valid', 1);
        if ($hostel_id == 0) {
            return AllotHostel::where('valid', 1)->whereNotIn('id', Requirement::all()->pluck('allot_hostel_id'))->whereNotIn('allotment_id', $allotments->pluck('id'));
        } else {
            return AllotHostel::where('hostel_id', $hostel_id)->where('valid', 1)->whereNotIn('id', Requirement::all()->pluck('allot_hostel_id'))->whereNotIn('allotment_id', $allotments->pluck('id'));
        }
    }
    public static function applied($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            return Requirement::where('new_hostel_id', '0');
        } else {
            return Requirement::where('hostel_id', $hostel_id)->where('new_hostel_id', '0');
        }
    }

    public static function resolved($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            return Requirement::where('new_hostel_id', '<>', '0')->where('notified', '0');
        } else {
            return Requirement::where('new_hostel_id', $hostel_id)->where('notified', '0');
        }
    }

    public static function notified($hostel_id = 0)
    {
        if ($hostel_id == 0) {
            // return Requirement::where('new_hostel_id', '<>', '0')->where('notified', '1');
            return Requirement::select('requirements.*')->join('sem_allots', 'sem_allots.requirement_id', 'requirements.id')->where('new_hostel_id', '<>', 0)->where('notified', '1')->orderBy('sem_allots.sl');
        } else {
            return Requirement::select('requirements.*')
                ->join('sem_allots', 'sem_allots.requirement_id', 'requirements.id')
                ->where('new_hostel_id', $hostel_id)->where('notified', '1')
                ->orderBy('sem_allots.notification_id')
                ->orderBy('sem_allots.sl');
            return Requirement::where('new_hostel_id', $hostel_id)->where('notified', '1');
        }
    }

    public function sem_allot()
    {
        return SemAllot::where('requirement_id', $this->id)->first();
    }

    public function valid_sem_allots()
    {
        return SemAllot::where('requirement_id', $this->id)->where('valid', 1)->get();
    }

    public function valid_sem_allot()
    {
        return SemAllot::where('requirement_id', $this->id)->where('valid', 1)->first();
    }

    public function duplicates()
    {
        $duplicates = DB::select("SELECT AP.*
            FROM requirements R JOIN (allot_hostels AH JOIN (allotments A JOIN (people P JOIN students S ON P.id=S.person_id) ON P.id=A.person_id) ON A.id=AH.allotment_id) ON AH.id=R.allot_hostel_id, applications AP
            WHERE R.id = " . $this->id . "  AND (P.name = AP.name OR S.mzuid = AP.mzuid OR P.mobile = AP.mobile OR P.email = AP.email)
            AND (AP.valid = 1 AND AP.status <> 'Declined')");
        //$duplicates['query'] = $str;
        return Application::hydrate($duplicates);
    }

    public function status()
    {
        if ($this->new_hostel_id == 0) {
            return "Applied";
        } else if ($this->notified == 0) {
            return "Resolved";
        } else {
            return "Notified";
        }
    }
}
