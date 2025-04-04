<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessn extends Model
{
    protected $guarded = [];

    public function name(){
        $str = $this->odd_even == 1?'odd':'even';
        return $this->start_yr . '-' . substr($this->end_yr,-2) . '(' . $str . ')';
    }

    public static function default(){
        return Sessn::where('current',1)->first();
    }

    public static function current(){
        return Sessn::where('current',1)->first();
    }
}
