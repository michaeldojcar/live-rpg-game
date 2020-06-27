<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdToPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function (Blueprint $table)
        {
            $table->unsignedInteger('group_id')->nullable()->after('name');
        });

        Schema::drop('group_player');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('players', function (Blueprint $table)
        {
            $table->dropColumn('group_id');
        });

        Schema::create('group_player', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('player_id');
            $table->timestamps();
        });
    }
}
