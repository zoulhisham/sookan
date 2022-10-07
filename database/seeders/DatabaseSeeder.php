<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            DB::transaction(function() {
                // Reset cached roles and permissions
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

                // create permissions
                Permission::create(['name' => 'users-view']);
                Permission::create(['name' => 'users-create']);
                Permission::create(['name' => 'users-update']);
                Permission::create(['name' => 'users-delete']);

                // create roles and assign created permissions
                $roleAdmin = Role::create(['name' => 'admin']);
                Role::create(['name' => 'user']);

                $roleAdmin->givePermissionTo(Permission::all());

                $user = User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@sookan.com',
                    'username' => 'admin',
                ]);

                $user->assignRole($roleAdmin);
                $user->givePermissionTo($roleAdmin->permissions->pluck('name')->toArray());
            });
        }
    }
}
