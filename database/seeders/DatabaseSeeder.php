<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@vilo.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        // Create Sample Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin-user@vilo.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@vilo.local',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Call ModuleSeeder to create all modules
        $this->call(ModuleSeeder::class);



        // Assign root-level modules to admin user (will cascade to children)
        $howWeWork = Module::where('slug', 'how-we-work')->first();
        $operationHandbook = Module::where('slug', 'operation-handbook')->first();

        if ($howWeWork) {
            $admin->modules()->attach($howWeWork->id);
        }

        if ($operationHandbook) {
            $admin->modules()->attach($operationHandbook->id);
        }

        // Assign limited modules to regular user (HRD only)
        $hrd = Module::where('slug', 'human-resource-development')->first();
        if ($hrd) {
            $user->modules()->attach($hrd->id);
        }
    }
}

