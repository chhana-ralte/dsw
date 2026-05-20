<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Test extends Model
{
    protected $guarded = [];

    public static function insert($request)
    {
        $test = Test::create([
            'num' => $request->num,
            'str' => $request->str,
            'dt' => $request->dt,
            'txt' => $request->txt,
        ]);
        return $test;
    }

    public function delete(){
        Test::where('id', $this->id)->delete();
        return $this;
    }

    public function update2($request){
        // $this->update([
        //     'num' => $request->num,
        //     'dt' => $request->dt,
        //     'str' => $request->str,
        //     'txt' => $request->txt,
        // ]);
        try{

            $this->num = "asd";
            // $this->num = $request->num;
            $this->dt = $request->dt;
            $this->str = $request->str;
            $this->txt = $request->txt;
            $this->save();
            return $this;
        }
        catch(Exception $e){
            return false;
        }

    }
}
