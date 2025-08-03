<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    protected $guarded = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public static function applied()
    {
        return Application::where('valid', 1)->where('status', 'Applied');
    }

    public static function approved()
    {
        return Application::where('valid', 1)->where('status', 'Approved')->where('hostel_id', 0);
    }
    public static function approved_hostel()
    {
        return Application::where('valid', 1)->where('status', 'Approved')->where('hostel_id', '<>', 0);
    }
    public static function notified()
    {
        return Application::where('valid', 1)->where('status', 'Notified')->where('hostel_id', '<>', 0);
    }
    public static function declined()
    {
        return Application::where('valid', 0)->orWhere('status', 'Declined')->orderBy('id');
    }

    public static function pending()
    {
        return Application::where('valid', 1)->where('status', 'Pending')->orderBy('id');
    }

    public function duplicates()
    {
        $duplicates = DB::select("SELECT A.id, P.name as name, P.mobile, P.email, S.mzuid as mzuid, S.course as course, S.department as department
            FROM allot_hostels AH JOIN (allotments A JOIN (people P JOIN students S ON P.id=S.person_id) ON P.id=A.person_id) ON A.id=AH.allotment_id, applications AP
            WHERE AP.id = '" . $this->id . "' AND (S.mzuid = AP.mzuid OR P.mobile = AP.mobile OR P.email = AP.email)
            AND AP.status <> 'Declined' AND AP.valid = 1;");
        return $duplicates;
        return Allotment::hydrate($duplicates);
    }

    public function existing_allotments()
    {
        $existing_allotments = DB::select("SELECT A.*
            FROM allotments A JOIN people P ON A.person_id = P.id
            JOIN students S ON S.person_id = P.id
            WHERE S.mzuid = '" . $this->mzuid . "'
            AND A.application_id <> '" . $this->id . "'
            ");

        return Allotment::hydrate($existing_allotments);
    }

    public static function status()
    {
        $manage = Manage::where('name', 'application')->first();
        return $manage->status;
    }

    public static function statusUpdate($status)
    {
        Manage::where('name', 'application')->update(['status' => $status]);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function allotment()
    {
        return $this->hasOne(Allotment::class);
    }
    public function valid_allotment()
    {
        return Allotment::where('application_id', $this->id)->where('valid', 1)->first();
    }
}
