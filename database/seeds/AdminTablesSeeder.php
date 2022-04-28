<?php

use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a role.
        AdminRole::truncate();
        AdminRole::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        //create a permission
        AdminPermission::truncate();
        AdminPermission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
        ]);

        AdminUser::truncate();
        for ($i = 1; $i <= 100; $i++) {
            if ($i === 1) {
                AdminUser::create([
                    'username' => 'admin',
                    'password' => bcrypt('admin'),
                    'name'     => 'Administrator',
                ]);
            } else {
                AdminUser::create([
                    'username' => "admin{$i}",
                    'password' => bcrypt("admin{$i}"),
                    'name'     => "Administrator{$i}",
                ]);
            }
            // add role to user.
            AdminUser::find($i)->roles()->save(AdminRole::first());
            // add permission to user.
            AdminUser::find($i)->permissions()->save(AdminPermission::first());
        }
    }
}
