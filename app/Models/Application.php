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
        return Application::where('status', 'Applied')->orderBy('id')->get();
    }

    public static function approved()
    {
        return Application::where('status', 'Approved')->orderBy('id')->get();
    }

    public static function declined()
    {
        return Application::where('status', 'Declined')->orderBy('id')->get();
    }

    public static function pending()
    {
        return Application::where('status', 'Pending')->orderBy('id')->get();
    }

    public function duplicates()
    {
        $duplicates = DB::select("SELECT A.id, P.name as name, P.mobile, P.email, S.mzuid as mzuid, S.course as course, S.department as department
            FROM requirements R JOIN (allot_hostels AH JOIN (allotments A JOIN (people P JOIN students S ON P.id=S.person_id) ON P.id=A.person_id) ON A.id=AH.allotment_id) ON AH.id=R.allot_hostel_id, applications AP
            WHERE AP.id = " . $this->id . "  AND (P.name = AP.name OR S.mzuid = AP.mzuid OR P.mobile = AP.mobile OR P.email = AP.email)");
        return $duplicates;
        return Allotment::hydrate($duplicates);
    }

    public function existing_allotments()
    {
        $existing_allotments = DB::select("SELECT A.* FROM allotments A JOIN people P ON A.person_id = P.id
            JOIN students S ON S.person_id = P.id WHERE S.mzuid = '" . $this->mzuid . "'");

        return Allotment::hydrate($existing_allotments);
    }
}
