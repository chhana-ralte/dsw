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
        Schema::table('users', function (Blueprint $table) {
            $table->ForeignIdFor(Person::class);
            // $table->BigInteger('person_id');
        });

        $role_users = Role_User::whereIn('type',['allotment','warden'])->get();
        foreach($role_users as $ru){
            if($ru->type == 'allotment'){
                $allotment = Allotment::find($ru->foreign_id);
                User::where('id',$ru->user_id)->update([
                    'person_id' => $allotment->person->id,
                ]);
            }
            else{
                $warden = Warden::find($ru->foreign_id);
                User::where('id',$ru->user_id)->update([
                    'person_id' => $warden->person->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->DropColumn('person_id');
        });
    }
};
