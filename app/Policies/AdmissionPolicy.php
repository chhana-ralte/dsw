<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admission;
use Illuminate\Support\Facades\DB;

class AdmissionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Admission $admission){
        if($user->isAdmin() || $user->isDsw()){
            return true;
        }
        else if($user->isWarden()){
            return true;
        }
        else if($user->isPrefectOf($hostel->id) || $user->isMessSecretaryOf($hostel->id)){
            return true;
        }
        else{
            return false;
        }
    }

    public function manage(User $user, Admission $admission){

        if($user->isAdmin() || $user->isDsw()){
            return true;
        }
        else if($user->isWarden()){
            return true;
        }
        else if($user->isPrefectOf($hostel->id) || $user->isMessSecretaryOf($hostel->id)){
            return true;
        }
        else{
            return false;
        }
    }

    public function manages(User $user){
        if($user->isAdmin() || $user->isDsw() || $user->isWarden()){
            return true;
        }
        else{
            return false;
        }
    }

    public function add_admission(User $user, Hostel $hostel){
        return $user->isWardenOf($hostel->id);
    }

    public function update_admission(User $user, Admission $admission){
        if($user->isDsw() || $user->isFinance() || ($user->allotment() && $admission->verified == 0)){
            return true;
        }
        else{
            return $user->isWardenOf($admission->allot_hostel->hostel_id);
        }
    }

    public function verify_admission(User $user, Admission $admission){
        if($user->isAdmin() || $user->isDsw()){
            return true;
        }
        else{
            $sql = "SELECT hostel_id "
                . "FROM admissions join allot_hostels ON admissions.allot_hostel_id allot_hostels.id "
                . "WHERE admissions.id = " . $admission->id;
            $row = DB::table('admissions')
                ->join('allot_hostels','admissions.allot_hostel_id','allot_hostels.id')
                ->where('admissions.id', $admission->id)
                ->select('allot_hostels.hostel_id')
                ->first();
            if($row){
                return $user->iswardenOf($row->hostel_id);
            }
            else{
                return false;
            }
        }

    }
}
