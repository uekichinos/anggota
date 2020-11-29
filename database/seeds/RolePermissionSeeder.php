<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'list user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'impersonate user']);

        Permission::create(['name' => 'list participant']);
        Permission::create(['name' => 'create participant']);
        Permission::create(['name' => 'edit participant']);
        Permission::create(['name' => 'view participant']);
        Permission::create(['name' => 'delete participant']);

        Permission::create(['name' => 'list role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'list activitylog']);
        Permission::create(['name' => 'view activitylog']);
        Permission::create(['name' => 'delete activitylog']);
        
        Permission::create(['name' => 'list logviewer']);
        Permission::create(['name' => 'view logviewer']);
        Permission::create(['name' => 'delete logviewer']);

        Permission::create(['name' => 'list permission']);

        Permission::create(['name' => 'edit setting']);
        
        Role::create(['name' => 'member']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        
        $user = User::find(1);
        $user->assignRole('admin');
    }
}
