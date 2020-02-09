<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->boolean('is_mother');
            $table->unsignedInteger('parent_quest_id')->nullable();
            $table->unsignedInteger('unlock_criteria');
            $table->boolean('allow_more_attempts');
            $table->boolean('allow_finish_repeatedly');
            $table->unsignedInteger('quest_owner_id');
            $table->string('reward_cash')->nullable();
            $table->string('reward_knowledge')->nullable();
            $table->unsignedInteger('reward_quest_unlock_id')->nullable();
            $table->boolean('is_reward_public');
            $table->boolean('is_dumb'); // Dávačka, odměnu dát hned při spuštění questu

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quests');
    }
}
