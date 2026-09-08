<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $table = 'payment2';
    protected $guarded = [];
    public $timestamps = false;

    public function application()
    {
        return Application::where('id', $this->application_id)->first();
    }

    public function paid() {}

    public function appl_mzuid()
    {
        return Application::where('mzuid', $this->mzuid)->first();
    }

    public function allotment()
    {
        return Allotment::where('application_id', $this->application_id)->first();
    }

    public function admission()
    {
        $sql = "SELECT admissions.*
            FROM payment2 JOIN applications ON applications.id=payment2.application_id
            JOIN allotments ON applications.id = allotments.application_id
            JOIN admissions ON allotments.id = admissions.allotment_id
            WHERE payment2.id = " . $this->id;

        $admissions = DB::select($sql);

        if ($admissions) {
            return $admissions[0];
        } else {
            return false;
        }
        if ($this->application()) {
            return $this->application()->admission();
        } else {
            return false;
        }
    }
}
