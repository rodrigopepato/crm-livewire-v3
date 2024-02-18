<?php

namespace Database\Seeders;

use App\Models\{Can, User};
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'  => 'Admin do CRM',
                'email' => 'admin@crm.com',
            ]);

        User::factory()->count(50)->create();
    }
}
