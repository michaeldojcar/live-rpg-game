<?php

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
        $p = new \App\Person();
        $p->name = 'Filip Vacula';
        $p->age = 12;
        $p->color_1 = 1;
        $p->color_2 = 2;
        $p->save();

        $p = new \App\Person();
        $p->name = 'Jan Vacula';
        $p->age = 14;
        $p->color_1 = 1;
        $p->color_2 = 2;
        $p->save();

        $p = new \App\Person();
        $p->name = 'Jan Mikoška';
        $p->age = 10;
        $p->color_1 = 1;
        $p->color_2 = 2;
        $p->save();
    }
}
