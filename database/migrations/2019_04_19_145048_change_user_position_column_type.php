<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserPositionColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users', 'position')) {
            Schema::table('users', function(Blueprint $table) {
                $table->dropColumn('position');
            });
        }


        if(Schema::hasColumn('users', 'team')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('position')->after('team');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
