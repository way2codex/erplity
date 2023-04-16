<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'mobile' => '1234567890'
            ]
        );
    }
}
