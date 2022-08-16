<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\User;
use DateTime;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Presidente',
            'social_reason' => 'Presidente',
            'phone' => 123456789,
            'rif' => 123456789,
            'direction' => 'Caracas',
            'password' => bcrypt('Temp*123'),
            'email' => 'presidente@test.com',
            'email_verified_at' => new DateTime(),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Director',
            'social_reason' => 'Director',
            'phone' => 123456789,
            'rif' => 123456789,
            'direction' => 'Caracas',
            'password' => bcrypt('Temp*123'),
            'email' => 'director@test.com',
            'email_verified_at' => new DateTime(),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'Analista',
            'social_reason' => 'Analista',
            'phone' => 123456789,
            'rif' => 123456789,
            'direction' => 'Caracas',
            'password' => bcrypt('Temp*123'),
            'email' => 'analista@test.com',
            'email_verified_at' => new DateTime(),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'Cliente',
            'social_reason' => 'Cliente',
            'phone' => 123456789,
            'rif' => 123456789,
            'direction' => 'Caracas',
            'password' => bcrypt('Temp*123'),
            'email' => 'cliente@test.com',
            'email_verified_at' => new DateTime(),
            'role_id' => 4
        ]);
    }
}
