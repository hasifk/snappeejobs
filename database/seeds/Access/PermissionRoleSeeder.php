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
        $this->insertEmployerRolePermission();
        $this->insertEmployeeStaffRolePermission();
        $this->addEmployerToStaff();
    }

    public function insertEmployeeStaffRolePermission(){
        $permissions = ['view-backend', 'view-access-management', 'employer-users-view', 'jobs-view',
            'mail-send-private-message', 'mail-view-private-messages', 'mail-send-group-messages'
        ];

        $employer_role_id = \DB::table('roles')->where('name', 'Employer Staff')->value('id');

        foreach ($permissions as $item) {

            $permission_id = \DB::table('permissions')->where('name', $item)->value('id');

            DB::table( config('access.permission_role_table') )->insert([
                'permission_id'     => $permission_id,
                'role_id'           => $employer_role_id
            ]);
        }
    }

    public function insertEmployerRolePermission(){
        $permissions = ['view-backend', 'view-access-management', 'employer-users-view', 'company-profile-view',
            'company-profile-edit', 'jobs-view', 'jobs-add', 'jobs-edit', 'jobs-change-status', 'jobs-delete',
            'mail-send-private-message', 'mail-view-private-messages', 'mail-send-group-messages', 'change-plan',
            'create-employer-staff'];

        $employer_role_id = \DB::table('roles')->where('name', 'Employer')->value('id');

        foreach ($permissions as $item) {

            $permission_id = \DB::table('permissions')->where('name', $item)->value('id');

            DB::table( config('access.permission_role_table') )->insert([
                'permission_id'     => $permission_id,
                'role_id'           => $employer_role_id
            ]);
        }
    }

    public function addEmployerToStaff()
    {
        \DB::table('staff_employer')->insert([
            'employer_id'   => 2,
            'user_id'       => 2,
            'is_admin'      => true
        ]);
    }

}
