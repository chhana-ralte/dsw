<?php

namespace App\Http\Controllers\diktei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zirlai;
use App\Models\Diktei;

class ZirlaiController extends Controller
{
    public function show(Zirlai $zirlai)
    {
        $dikteis = Diktei::where('zirlai_id', $zirlai->id)->orderBy('serial')->get();
        $data = [
            'dikteis' => $dikteis,
            'zirlai' => $zirlai,
        ];
        return view('diktei.zirlai.show', $data);
    }
}
