<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Kovář';
        $role->real_name = 'Matěj Kulišťák';
        $role->story = 'Blablabla';
        $role->action_recommends = 'Blablabla';
        $role->place_recommends = 'Červotoč - vchod';
        $role->save();

        $role = new Role();
        $role->name = 'Poutník';
        $role->real_name = 'Michael Dojčár';
        $role->story = 'Blablabla';
        $role->action_recommends = 'Blablabla';
        $role->place_recommends = 'Červotoč - vchod';
        $role->save();

        $role = new Role();
        $role->name = 'Šermíř';
        $role->real_name = 'Lada Radmacherová';
        $role->story = 'Blablabla';
        $role->action_recommends = 'Blablabla';
        $role->place_recommends = 'Červotoč - vchod';
        $role->save();

    }
}
