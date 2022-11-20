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
        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
        ]);
        $admin->is_admin = true;
        $admin->save();

        User::factory(DatabaseSeeder::USERS_AMOUNT - 1)->create();
    }
}
