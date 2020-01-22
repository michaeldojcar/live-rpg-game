<?php

use App\Person;
use App\Quest;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q = new Quest();
        $q->name = 'Získání hřebíků';
        $q->description = 'Potřebuju aspoň 15 hřebíků od trhovce.';
        $q->is_mother = 1;
        $q->mother_quest_id = null;
        $q->unlock_criteria = 2;
        $q->allow_more_attempts = true;
        $q->allow_finish_repeatedly = false;
        $q->quest_owner_id = 1;
        $q->reward_cash = 500;
        $q->reward_knowledge = null;
        $q->is_reward_public = false;
        $q->is_dumb = false;
        $q->save();

        $q->persons()->attach(Person::first(), ['status' => 2]);

        $q = new Quest();
        $q->name = 'Získání ovčího rouna';
        $q->description = 'Potřebuju velké ovčí rouno';
        $q->is_mother = 1;
        $q->mother_quest_id = null;
        $q->unlock_criteria = 2;
        $q->allow_more_attempts = true;
        $q->allow_finish_repeatedly = false;
        $q->quest_owner_id = 1;
        $q->reward_cash = 500;
        $q->reward_knowledge = null;
        $q->is_reward_public = false;
        $q->is_dumb = false;
        $q->save();

        $q->persons()->attach(Person::first(), ['status' => 3]);

        $q = new Quest();
        $q->name = '5 dřepů';
        $q->description = 'Musí udělat 5 dřepů';
        $q->is_mother = 0;
        $q->mother_quest_id = 1;
        $q->unlock_criteria = 2;
        $q->allow_more_attempts = true;
        $q->allow_finish_repeatedly = false;
        $q->quest_owner_id = 1;
        $q->reward_cash = 9;
        $q->reward_knowledge = null;
        $q->is_reward_public = false;
        $q->is_dumb = false;
        $q->save();

        $q->persons()->attach(Person::first(), ['status' => 3]);
    }
}
