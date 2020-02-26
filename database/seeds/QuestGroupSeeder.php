<?php

use App\QuestGroup;
use Illuminate\Database\Seeder;

class QuestGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qg         = new QuestGroup();
        $qg->name   = 'Komplexní větev';
        $qg->active = true;
        $qg->save();

        $qg         = new QuestGroup();
        $qg->name   = '1. den (drak)';
        $qg->active = false;
        $qg->save();

        $qg         = new QuestGroup();
        $qg->name   = '2. den (drak je nesmrtelný)';
        $qg->active = false;
        $qg->save();
    }
}
