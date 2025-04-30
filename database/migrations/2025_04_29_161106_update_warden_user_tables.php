<?php
namespace App\Models;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role_users = Role_User::where('type','hostel')->get();
        foreach($role_users as $ru){
            $warden = Warden::where('hostel_id',$ru->foreign_id)->where('valid',1)->first();
            User::where('id',$ru->user_id)->update([
                'name' => $warden->person->name,
            ]);
            $ru->update([
                'type' => 'warden',
                'foreign_id' => $warden->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
