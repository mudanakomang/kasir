<?php

use Illuminate\Database\Seeder;

class GuideTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $guide =new \App\Guide();
        $guide->name='Guide A';
        $guide->telp='081234567890';
        $guide->tgl_masuk=\Carbon\Carbon::now()->format('Y-m-d');
        $guide->honor='2000000';
        $guide->save();
    }
}
