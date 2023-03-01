<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin',]);
        $roleAdmin = Role::create(['name' => 'editor']);
        $roleUser = Role::create(['name' => 'user']);

        $permissionAdmin = Permission::create([
            'name' => 'view_all_user',
            'name' => 'view_detail_user',
            'name' => 'create_user',
            'name' => 'update_user',
            'name' => 'delete_user',
            'name' => 'view_all_post',
            'name' => 'view_detail_post',
            'name' => 'create_post',
            'name' => 'update_post',
            'name' => 'delete_post',
            'name' => 'view_all_category',
            'name' => 'view_detail_category',
            'name' => 'create_category',
            'name' => 'update_category',
            'name' => 'delete_category',
        ]);

        $permissionEditor = Permission::create([
            'name' => 'view_all_post',
            'name' => 'view_detail_post',
            'name' => 'create_post',
            'name' => 'update_post',
            'name' => 'delete_post',
        ]);

        $roleAdmin->givePermissionTo($permissionAdmin);
        $roleAdmin->givePermissionTo($permissionEditor);
        $roleUser->givePermissionTo($permissionEditor);
    }
}
