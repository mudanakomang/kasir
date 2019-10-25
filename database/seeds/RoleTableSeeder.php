<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roleadmin=new \App\Role();
        $roleadmin->name='admin';
        $roleadmin->description='Admin';
        $roleadmin->save();

        $rolekasir=new \App\Role();
        $rolekasir->name='kasir';
        $rolekasir->description='Kasir';
        $rolekasir->save();

        $rolekonter=new \App\Role();
        $rolekonter->name='konter';
        $rolekonter->description='Konter';
        $rolekonter->save();
    }
}
