<?php


use Illuminate\Database\Seeder;

class SettingAbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_absen')->insert([
            'palingcepat' => '1 hour 2 minutes',
            'palinglambat'=>'1 hour 2 minutes',
            'date_create_gaji' => '01',
        ]);
    }
}
