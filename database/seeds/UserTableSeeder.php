<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin=\App\Role::where('name','=','admin')->first();
        $kasir=\App\Role::where('name','=','kasir')->first();
        $konter=\App\Role::where('name','=','konter')->first();

        $admin1=new \App\User();
        $admin1->name='Admin 1';
        $admin1->username='admin';
        $admin1->password=bcrypt('admin');
        $admin1->save();
        $admin1->roles()->attach($admin);

        $kasir1=new \App\User();
        $kasir1->name='Kasir 1';
        $kasir1->username='kasir';
        $kasir1->password=bcrypt('kasir');
        $kasir1->save();
        $kasir1->roles()->attach($kasir);

        $konter1=new \App\User();
        $konter1->name='Konter 1';
        $konter1->username='konter';
        $konter1->password=bcrypt('konter');
        $konter1->save();
        $konter1->roles()->attach($konter);
    }
}
