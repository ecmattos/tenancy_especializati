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
        factory(\App\Entities\User::class, 1)
            ->states('admin')
            ->create([
                'email' => 'admin@gmail.com',
                'is_verified' => 1
            ]);

        factory(\App\Entities\User::class, 1)
            ->create([
                'email' => 'client@gmail.com'
            ]);
    }
}
