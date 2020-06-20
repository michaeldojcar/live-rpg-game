<?php

use App\Player;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Player();
        $p->name = 'Filip Vacula';
        $p->birth_date = Carbon::now()->subYears(8);
        $p->color_1 = 1;
        $p->color_2 = 1;
        $p->color_3 = 1;
        $p->last_seen = Carbon::now();
        $p->save();

        $p = new Player();
        $p->name = 'Jan Vacula';
        $p->birth_date = Carbon::now()->subYears(17);
        $p->color_1 = 1;
        $p->color_2 = 2;
        $p->color_3 = 1;
        $p->last_seen = Carbon::now();
        $p->save();

        $p = new Player();
        $p->name = 'Jan Mikoška';
        $p->birth_date = Carbon::now()->subYears(12);
        $p->color_1 = 1;
        $p->color_2 = 2;
        $p->color_3 = 1;
        $p->last_seen = Carbon::now();
        $p->save();
    }
}
