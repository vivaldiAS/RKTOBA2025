<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'username' => 'jerryandriantop',
                'email' => 'jerryandrianto22@gmail.com',
                'password' => Hash::make('jerry123'),
                'is_admin' => true
            ],
            [
                'username' => 'ricky1304',
                'email' => 'rickypangaribuan@gmail.com',
                'password' => Hash::make('ricky123'),
                'is_admin' => false
            ],
        ]);
        // $user = new User;
        // $user->username = "admin";
        // $user->email = "admin@gmail.com";
        // $user->password = bcrypt('admin');
        // $user->is_admin = 1;
        // $user->save();
    }
}
