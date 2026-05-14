<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = [];

    public static function insert($request)
    {
        return $request->num;
    }
}
