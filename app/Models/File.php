<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public static function upload($file, $args){
        $path = $file->store('upload', 'public');
        $newfile = File::create([
            'path' => '/storage/' . $path,
            'name' => isset($args['name'])?$args['name']:'',
            'type' => isset($args['type'])?$args['type']:'',
            'remark' => isset($args['remark'])?$args['remark']:'',
        ]);
        return $newfile;
    }
}
