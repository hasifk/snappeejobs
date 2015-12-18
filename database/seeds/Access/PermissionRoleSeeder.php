<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

        foreach ($permissions as $item) {
            DB::table( config('access.permission_role_table') )->insert([
                'permission_id'     => $item,
                'role_id'           => 2
            ]);
        }

    }
}
