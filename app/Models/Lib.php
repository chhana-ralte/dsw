<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lib extends Model
{
    protected $table = null;

    public static function rand(int $size = 2){
        $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $len = strlen($chars);
        $str = '';
        for ($i = 0; $i < $size; $i++) {
            $str .= $chars[rand(0, $len - 1)];
        }
        return $str;
    }
}
