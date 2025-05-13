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

    public static function between_sessns(Sessn $start, Sessn $end){
        return Sessn::where('id','>=',$start->id)->where('id','<=',$end->id)->orderBy('start_yr')->orderBy('odd_even')->get();
    }

    public function set_default(Sessn $sessn){
        Sessn::where('current',1)->update(['current' => 0]);
        $sessn->update(['current' => 1]);
    }

    public static function current(){
        return Sessn::where('current',1)->first();
    }

    public function make_default(){
        Sessn::where('current',1)->update(['current' => 0]);
        $this->update(['current' => 1]);
    }

    public function prev(){
        $start_yr = $this->odd_even == 1? $this->start_yr - 1 : $this->start_yr;
        $odd_even = $this->odd_even == 1? 2: 1;
        return Sessn::where('start_yr',$start_yr)->where('odd_even',$odd_even)->first();
    }

    public function next(){
        $start_yr = $this->odd_even == 1? $this->start_yr : $this->start_yr + 1;
        $odd_even = $this->odd_even == 1? 2: 1;
        return Sessn::where('start_yr',$start_yr)->where('odd_even',$odd_even)->first();
    }
}
