<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    public function sub_sections()
    {
        return Section::where('section_id', $this->id)->get();
    }
}
