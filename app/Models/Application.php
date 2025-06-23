<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public static function applied(){
        return Application::where('status','Applied')->orderBy('id')->get();
    }

    public static function approved(){
        return Application::where('status','Approved')->orderBy('id')->get();
    }

    public static function declined(){
        return Application::where('status','Declined')->orderBy('id')->get();
    }

    public static function pending(){
        return Application::where('status','Pending')->orderBy('id')->get();
    }
}
