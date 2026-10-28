<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [

            'view users',
            'create users',
            'edit users',
            'delete users',

            'view estates',
            'manage estates',

            'view houses',
            'manage houses',

            'view tenants',
            'manage tenants',

            'view payments',
            'manage payments',

            'view reports',

            'view maintenance',
            'manage maintenance',

            'view visitors',
            'manage visitors',

            'manage settings',

        ];

        foreach($permissions as $permission)
        {
            Permission::create([
                'name'=>$permission
            ]);
        }

        $superAdmin = Role::create([
            'name'=>'Super Admin'
        ]);


        $estateManager = Role::create([
            'name'=>'Estate Manager'
        ]);

        $accountant = Role::create([
            'name'=>'Accountant'
        ]);

        $receptionist = Role::create([
            'name'=>'Receptionist'
        ]);


        $maintenance = Role::create([
            'name'=>'Maintenance Officer'
        ]);


        $security = Role::create([
            'name'=>'Security'
        ]);


        $tenant = Role::create([
            'name'=>'Tenant'
        ]);

        $superAdmin->givePermissionTo(
            Permission::all()
        );

        $estateManager->givePermissionTo([

            'view estates',
            'manage estates',

            'view houses',
            'manage houses',

            'view tenants',
            'manage tenants',

            'view maintenance',
            'manage maintenance',

            'view reports'

        ]);

        $accountant->givePermissionTo([

            'view payments',
            'manage payments',

            'view reports'

        ]);

        $receptionist->givePermissionTo([

            'view tenants',
            'manage tenants',

            'view visitors',
            'manage visitors'

        ]);

        $maintenance->givePermissionTo([

            'view maintenance',
            'manage maintenance'

        ]);

        $security->givePermissionTo([

            'view visitors',
            'manage visitors'

        ]);

    }
}