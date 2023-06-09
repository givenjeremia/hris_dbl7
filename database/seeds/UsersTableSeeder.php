<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
    */
    public function run()
    {
        $users = [
            [
                'name' => 'super admin',
                'username'=>'superadmin',
                'email' => 'superadmin@gmail.com',
                'telp'=>'09849020989',
                'level'=>'super admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'admin',
                'username'=>'admin',
                'email' => 'admin@gmail.com',
                'telp'=>'09849020989',
                'level'=>'admin',
                'password' => Hash::make('12345678'),
            ]

        ];
        DB::table('users')->insert($users);
    }
}
