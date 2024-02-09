<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->withPermission('be an admin')
            ->create([
                'name'  => 'Admin do CRM',
                'email' => 'admin@crm.com',
            ]);
    }
}
