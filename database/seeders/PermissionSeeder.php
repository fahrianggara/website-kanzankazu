<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorities = config('permission.authorities');

        $listPermission = [];
        $miminPermissions = [];
        $adminPermissions = [];
        $editorPermissions = [];

        foreach ($authorities as $label => $permissions) {
            // pecahkan lagi
            foreach ($permissions as $permission) {

                $listPermission[] = [
                    "name" => $permission,
                    'guard_name' => 'web',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                ];
                // mimin
                $miminPermissions[] = $permission;
                // admin
                if (in_array($label, ['manage_posts', 'manage_categories', 'manage_tags', 'manage_inbox'])) {
                    $adminPermissions[] = $permission;
                }
                // editor
                if (in_array($label, ['manage_posts'])) {
                    $editorPermissions[] = $permission;
                }
            }
        }

        /**
         * Insert data PERMISSION
         */
        Permission::insert($listPermission);

        /**
         * Insert data ROLE
         */

        // SUPER ADMIN
        $mimin = Role::create([
            "name" => "Mimin",
            'guard_name' => 'web',
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]);
        // ADMIN
        $admin = Role::create([
            "name" => "Admin",
            'guard_name' => 'web',
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]);
        // Editor
        $editor = Role::create([
            "name" => "Editor",
            'guard_name' => 'web',
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]);

        // ketika sudah dimasukkan ke database kita kasih permissionnya(hak akses)
        $mimin->givePermissionTo($miminPermissions);
        $admin->givePermissionTo($adminPermissions);
        $editor->givePermissionTo($editorPermissions);

        // kita jadikan user berdasarkan id dan kasihkan user itu ke role mimin, admin dan editor
        User::find(1)->assignRole("Mimin");
        User::find(2)->assignRole("Mimin");

        /**
         * pengecekan datanya masuk apa tidak..
         *
         * dd in terminal = php artisan db:seed --class=PermissionTableSeeder
         *
         * dd("Super Admin", $superAdminPermissions);
         * dd("Admin", $adminPermissions);
         * dd("Editor", $editorPermissions);
         * dd($listPermission);
         */
    }
}
