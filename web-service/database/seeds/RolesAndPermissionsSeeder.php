<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
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
        // create permissons
        //user
        Permission::create(['guard_name'=>'api-employee','name' => 'create-user']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-user']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-user']);
        Permission::create(['guard_name'=>'api-employee','name' => 'ban-user']);
        //order
        Permission::create(['guard_name'=>'api-employee','name' => 'create-order']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-order']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-order']);
        Permission::create(['guard_name'=>'api-employee','name' => 'delete-order']);
        //packages
        Permission::create(['guard_name'=>'api-employee','name' => 'create-packages']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-packages']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-packages']);
        Permission::create(['guard_name'=>'api-employee','name' => 'delete-packages']);
        //manager
        Permission::create(['guard_name'=>'api-employee','name' => 'create-manager']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-manager']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-manager']);
        Permission::create(['guard_name'=>'api-employee','name' => 'ban-manager']);
        //receptionist
        Permission::create(['guard_name'=>'api-employee','name' => 'create-receptionist']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-receptionist']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-receptionist']);
        Permission::create(['guard_name'=>'api-employee','name' => 'ban-receptionist']);
        //shipper
        Permission::create(['guard_name'=>'api-employee','name' => 'create-shipper']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-shipper']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-shipper']);
        Permission::create(['guard_name'=>'api-employee','name' => 'ban-shipper']);
        //transaction points
        Permission::create(['guard_name'=>'api-employee','name' => 'create-transaction-points']);
        Permission::create(['guard_name'=>'api-employee','name' => 'read-transaction-points']);
        Permission::create(['guard_name'=>'api-employee','name' => 'update-transaction-points']);
        Permission::create(['guard_name'=>'api-employee','name' => 'delete-transaction-points']);
        //admin permisson
        Permission::create(['guard_name'=>'api-employee','name' => 'orders-statics']);
        Permission::create(['guard_name'=>'api-employee','name' => 'role-employee']);

        //create role receptionist
        $role = Role::create(['guard_name'=>'api-employee','name' => 'receptionist']);
        $role->givePermissionTo(['create-user','create-order','read-order','update-order']);
        //create role manager
        $role = Role::create(['guard_name'=>'api-employee','name' => 'manager'])
            ->givePermissionTo(['create-user', 'create-order','read-order','update-order',
            'create-receptionist','read-receptionist','update-receptionist','ban-receptionist',
            'create-shipper','read-shipper','update-shipper','ban-shipper']);
        //create role shipper, role shipper doesn't have permissons
        $role = Role::create(['guard_name'=>'api-employee','name' => 'shipper']);
        //create role admin
        $role = Role::create(['guard_name'=>'api-employee','name' => 'admin'])
        ->givePermissionTo(['orders-statics','role-employee','create-transaction-points',
                            'create-transaction-points','read-transaction-points',
                            'update-transaction-points','delete-transaction-points',
                            'create-manager','read-manager',
                            'update-manager','ban-manager',]);
    }
}
