<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'duvan.caballero@hotmail.com')->first();
        if (is_null($user)) {
            $user = new User();
            $user->name = "Duvan Caballero";
            $user->email = "duvan.caballero@hotmail.com";
            $user->password = bcrypt('12345678');
            $user->save();
        }
    }
}
