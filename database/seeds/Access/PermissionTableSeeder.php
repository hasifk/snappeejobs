<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder {

	public function run() {

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if(env('DB_DRIVER') == 'mysql')
		{
			DB::table(config('access.permissions_table'))->truncate();
			DB::table(config('access.permission_role_table'))->truncate();
			DB::table(config('access.permission_user_table'))->truncate();
		} elseif(env('DB_DRIVER') == 'sqlite') {
			DB::statement("DELETE FROM ".config('access.permissions_table'));
			DB::statement("DELETE FROM ".config('access.permission_role_table'));
			DB::statement("DELETE FROM ".config('access.permission_user_table'));
		} else { //For PostgreSQL or anything else
			DB::statement("TRUNCATE TABLE ".config('access.permissions_table')." CASCADE");
			DB::statement("TRUNCATE TABLE ".config('access.permission_role_table')." CASCADE");
			DB::statement("TRUNCATE TABLE ".config('access.permission_user_table')." CASCADE");
		}

		//Don't need to assign any permissions to administrator because the all flag is set to true

		/**
		 * Misc Access Permissions
		 */
		$permission_model = config('access.permission');
		$viewBackend = new $permission_model;
		$viewBackend->name = 'view-backend';
		$viewBackend->display_name = 'View Backend';
		$viewBackend->system = true;
		$viewBackend->group_id = 1;
		$viewBackend->sort = 1;
		$viewBackend->created_at = Carbon::now();
		$viewBackend->updated_at = Carbon::now();
		$viewBackend->save();

		$permission_model = config('access.permission');
		$viewAccessManagement = new $permission_model;
		$viewAccessManagement->name = 'view-access-management';
		$viewAccessManagement->display_name = 'View Access Management';
		$viewAccessManagement->system = true;
		$viewAccessManagement->group_id = 1;
		$viewAccessManagement->sort = 2;
		$viewAccessManagement->created_at = Carbon::now();
		$viewAccessManagement->updated_at = Carbon::now();
		$viewAccessManagement->save();

		/**
		 * Access Permissions
		 */

		/**
		 * Employer Permissions
		 */
        $permission_model = config('access.permission');
		$employerAccount = new $permission_model;
        $employerAccount->name = 'employer-users-view';
        $employerAccount->display_name = 'Employers List View';
        $employerAccount->system = true;
        $employerAccount->group_id = 2;
        $employerAccount->sort = 1;
        $employerAccount->created_at = Carbon::now();
        $employerAccount->updated_at = Carbon::now();
        $employerAccount->save();

        $permission_model = config('access.permission');
        $companyProfileView = new $permission_model;
        $companyProfileView->name = 'company-profile-view';
        $companyProfileView->display_name = 'Company Profile View';
        $companyProfileView->system = true;
        $companyProfileView->group_id = 2;
        $companyProfileView->sort = 2;
        $companyProfileView->created_at = Carbon::now();
        $companyProfileView->updated_at = Carbon::now();
        $companyProfileView->save();

        $permission_model = config('access.permission');
        $companyProfileEdit = new $permission_model;
        $companyProfileEdit->name = 'company-profile-edit';
        $companyProfileEdit->display_name = 'Company Profile Edit';
        $companyProfileEdit->system = true;
        $companyProfileEdit->group_id = 2;
        $companyProfileEdit->sort = 3;
        $companyProfileEdit->created_at = Carbon::now();
        $companyProfileEdit->updated_at = Carbon::now();
        $companyProfileEdit->save();

        $permission_model = config('access.permission');
        $jobsView = new $permission_model;
        $jobsView->name = 'employer-jobs-view';
        $jobsView->display_name = 'Jobs View';
        $jobsView->system = true;
        $jobsView->group_id = 2;
        $jobsView->sort = 4;
        $jobsView->created_at = Carbon::now();
        $jobsView->updated_at = Carbon::now();
        $jobsView->save();

        $permission_model = config('access.permission');
        $jobsAdd = new $permission_model;
        $jobsAdd->name = 'employer-jobs-add';
        $jobsAdd->display_name = 'Jobs Add';
        $jobsAdd->system = true;
        $jobsAdd->group_id = 2;
        $jobsAdd->sort = 5;
        $jobsAdd->created_at = Carbon::now();
        $jobsAdd->updated_at = Carbon::now();
        $jobsAdd->save();

        $permission_model = config('access.permission');
        $jobsEdit = new $permission_model;
        $jobsEdit->name = 'employer-jobs-edit';
        $jobsEdit->display_name = 'Jobs Edit';
        $jobsEdit->system = true;
        $jobsEdit->group_id = 2;
        $jobsEdit->sort = 6;
        $jobsEdit->created_at = Carbon::now();
        $jobsEdit->updated_at = Carbon::now();
        $jobsEdit->save();

        $permission_model = config('access.permission');
        $jobsChangeStatus = new $permission_model;
        $jobsChangeStatus->name = 'employer-jobs-change-status';
        $jobsChangeStatus->display_name = 'Jobs Change Status';
        $jobsChangeStatus->system = true;
        $jobsChangeStatus->group_id = 2;
        $jobsChangeStatus->sort = 7;
        $jobsChangeStatus->created_at = Carbon::now();
        $jobsChangeStatus->updated_at = Carbon::now();
        $jobsChangeStatus->save();

        $permission_model = config('access.permission');
        $jobsChangeStatus = new $permission_model;
        $jobsChangeStatus->name = 'employer-jobs-delete';
        $jobsChangeStatus->display_name = 'Jobs Delete';
        $jobsChangeStatus->system = true;
        $jobsChangeStatus->group_id = 2;
        $jobsChangeStatus->sort = 8;
        $jobsChangeStatus->created_at = Carbon::now();
        $jobsChangeStatus->updated_at = Carbon::now();
        $jobsChangeStatus->save();

        $permission_model = config('access.permission');
        $mailSendMessage = new $permission_model;
        $mailSendMessage->name = 'mail-send-private-message';
        $mailSendMessage->display_name = 'Mail Send Private Message';
        $mailSendMessage->system = true;
        $mailSendMessage->group_id = 2;
        $mailSendMessage->sort = 9;
        $mailSendMessage->created_at = Carbon::now();
        $mailSendMessage->updated_at = Carbon::now();
        $mailSendMessage->save();

        $permission_model = config('access.permission');
        $mailViewMessages = new $permission_model;
        $mailViewMessages->name = 'mail-view-private-messages';
        $mailViewMessages->display_name = 'Mail View Private Messages';
        $mailViewMessages->system = true;
        $mailViewMessages->group_id = 2;
        $mailViewMessages->sort = 10;
        $mailViewMessages->created_at = Carbon::now();
        $mailViewMessages->updated_at = Carbon::now();
        $mailViewMessages->save();

        $permission_model = config('access.permission');
        $mailSendGroupMessages = new $permission_model;
        $mailSendGroupMessages->name = 'mail-send-group-messages';
        $mailSendGroupMessages->display_name = 'Mail Send Group Message';
        $mailSendGroupMessages->system = true;
        $mailSendGroupMessages->group_id = 2;
        $mailSendGroupMessages->sort = 11;
        $mailSendGroupMessages->created_at = Carbon::now();
        $mailSendGroupMessages->updated_at = Carbon::now();
        $mailSendGroupMessages->save();

        $permission_model = config('access.permission');
        $mailSendGroupMessages = new $permission_model;
        $mailSendGroupMessages->name = 'change-plan';
        $mailSendGroupMessages->display_name = 'Change Subscription Plan';
        $mailSendGroupMessages->system = true;
        $mailSendGroupMessages->group_id = 2;
        $mailSendGroupMessages->sort = 11;
        $mailSendGroupMessages->created_at = Carbon::now();
        $mailSendGroupMessages->updated_at = Carbon::now();
        $mailSendGroupMessages->save();

		$permission_model = config('access.permission');
		$createEmployerStaff = new $permission_model;
		$createEmployerStaff->name = 'create-employer-staff';
		$createEmployerStaff->display_name = 'Create Employer Staff';
		$createEmployerStaff->system = true;
		$createEmployerStaff->group_id = 2;
		$createEmployerStaff->sort = 12;
		$createEmployerStaff->created_at = Carbon::now();
		$createEmployerStaff->updated_at = Carbon::now();
		$createEmployerStaff->save();

		$permission_model = config('access.permission');
		$editEmployerStaff = new $permission_model;
		$editEmployerStaff->name = 'edit-employer-staff';
		$editEmployerStaff->display_name = 'Edit Employer Staff';
		$editEmployerStaff->system = true;
		$editEmployerStaff->group_id = 2;
		$editEmployerStaff->sort = 13;
		$editEmployerStaff->created_at = Carbon::now();
		$editEmployerStaff->updated_at = Carbon::now();
		$editEmployerStaff->save();

		$permission_model = config('access.permission');
		$changeEmployerStaffPassword = new $permission_model;
		$changeEmployerStaffPassword->name = 'change-employer-staff-password';
		$changeEmployerStaffPassword->display_name = 'Change Employer Staff Password';
		$changeEmployerStaffPassword->system = true;
		$changeEmployerStaffPassword->group_id = 2;
		$changeEmployerStaffPassword->sort = 13;
		$changeEmployerStaffPassword->created_at = Carbon::now();
		$changeEmployerStaffPassword->updated_at = Carbon::now();
		$changeEmployerStaffPassword->save();

		$permission_model = config('access.permission');
		$deactivateEmployerStaff = new $permission_model;
		$deactivateEmployerStaff->name = 'deactivate-employer-staff';
		$deactivateEmployerStaff->display_name = 'Deactivate Employer Staff';
		$deactivateEmployerStaff->system = true;
		$deactivateEmployerStaff->group_id = 2;
		$deactivateEmployerStaff->sort = 13;
		$deactivateEmployerStaff->created_at = Carbon::now();
		$deactivateEmployerStaff->updated_at = Carbon::now();
		$deactivateEmployerStaff->save();

		$permission_model = config('access.permission');
		$reactivateEmployerStaff = new $permission_model;
		$reactivateEmployerStaff->name = 'reactivate-employer-staff';
		$reactivateEmployerStaff->display_name = 'Reactivate Employer Staff';
		$reactivateEmployerStaff->system = true;
		$reactivateEmployerStaff->group_id = 2;
		$reactivateEmployerStaff->sort = 13;
		$reactivateEmployerStaff->created_at = Carbon::now();
		$reactivateEmployerStaff->updated_at = Carbon::now();
		$reactivateEmployerStaff->save();

		$permission_model = config('access.permission');
		$banEmployerStaff = new $permission_model;
		$banEmployerStaff->name = 'ban-employer-staff';
		$banEmployerStaff->display_name = 'Ban Employer Staff';
		$banEmployerStaff->system = true;
		$banEmployerStaff->group_id = 2;
		$banEmployerStaff->sort = 13;
		$banEmployerStaff->created_at = Carbon::now();
		$banEmployerStaff->updated_at = Carbon::now();
		$banEmployerStaff->save();

		$permission_model = config('access.permission');
		$unbanEmployer = new $permission_model;
		$unbanEmployer->name = 'unban-employer-staff';
		$unbanEmployer->display_name = 'Un-Ban Employer Staff';
		$unbanEmployer->system = true;
		$unbanEmployer->group_id = 3;
		$unbanEmployer->sort = 12;
		$unbanEmployer->created_at = Carbon::now();
		$unbanEmployer->updated_at = Carbon::now();
		$unbanEmployer->save();

		$permission_model = config('access.permission');
		$deleteEmployerStaff = new $permission_model;
		$deleteEmployerStaff->name = 'delete-employer-staff';
		$deleteEmployerStaff->display_name = 'Delete Employer Staff';
		$deleteEmployerStaff->system = true;
		$deleteEmployerStaff->group_id = 2;
		$deleteEmployerStaff->sort = 13;
		$deleteEmployerStaff->created_at = Carbon::now();
		$deleteEmployerStaff->updated_at = Carbon::now();
		$deleteEmployerStaff->save();

		$permission_model = config('access.permission');
		$EmployerResendConfirmationEmail = new $permission_model;
		$EmployerResendConfirmationEmail->name = 'employer-resend-confirmation-email';
		$EmployerResendConfirmationEmail->display_name = 'Employee Staff Resend Confirmation Email';
		$EmployerResendConfirmationEmail->system = true;
		$EmployerResendConfirmationEmail->group_id = 2;
		$EmployerResendConfirmationEmail->sort = 13;
		$EmployerResendConfirmationEmail->created_at = Carbon::now();
		$EmployerResendConfirmationEmail->updated_at = Carbon::now();
		$EmployerResendConfirmationEmail->save();
		/**
		 * Employer Permissions
		 */

		/**
		 * User
		 */
		$permission_model = config('access.permission');
		$createUsers = new $permission_model;
		$createUsers->name = 'create-users';
		$createUsers->display_name = 'Create Users';
		$createUsers->system = true;
		$createUsers->group_id = 3;
		$createUsers->sort = 5;
		$createUsers->created_at = Carbon::now();
		$createUsers->updated_at = Carbon::now();
		$createUsers->save();

		$permission_model = config('access.permission');
		$editUsers = new $permission_model;
		$editUsers->name = 'edit-users';
		$editUsers->display_name = 'Edit Users';
		$editUsers->system = true;
		$editUsers->group_id = 3;
		$editUsers->sort = 6;
		$editUsers->created_at = Carbon::now();
		$editUsers->updated_at = Carbon::now();
		$editUsers->save();

		$permission_model = config('access.permission');
		$deleteUsers = new $permission_model;
		$deleteUsers->name = 'delete-users';
		$deleteUsers->display_name = 'Delete Users';
		$deleteUsers->system = true;
		$deleteUsers->group_id = 3;
		$deleteUsers->sort = 7;
		$deleteUsers->created_at = Carbon::now();
		$deleteUsers->updated_at = Carbon::now();
		$deleteUsers->save();

		$permission_model = config('access.permission');
		$changeUserPassword = new $permission_model;
		$changeUserPassword->name = 'change-user-password';
		$changeUserPassword->display_name = 'Change User Password';
		$changeUserPassword->system = true;
		$changeUserPassword->group_id = 3;
		$changeUserPassword->sort = 8;
		$changeUserPassword->created_at = Carbon::now();
		$changeUserPassword->updated_at = Carbon::now();
		$changeUserPassword->save();

		$permission_model = config('access.permission');
		$deactivateUser = new $permission_model;
		$deactivateUser->name = 'deactivate-users';
		$deactivateUser->display_name = 'Deactivate Users';
		$deactivateUser->system = true;
		$deactivateUser->group_id = 3;
		$deactivateUser->sort = 9;
		$deactivateUser->created_at = Carbon::now();
		$deactivateUser->updated_at = Carbon::now();
		$deactivateUser->save();

		$permission_model = config('access.permission');
		$banUsers = new $permission_model;
		$banUsers->name = 'ban-users';
		$banUsers->display_name = 'Ban Users';
		$banUsers->system = true;
		$banUsers->group_id = 3;
		$banUsers->sort = 10;
		$banUsers->created_at = Carbon::now();
		$banUsers->updated_at = Carbon::now();
		$banUsers->save();

		$permission_model = config('access.permission');
		$reactivateUser = new $permission_model;
		$reactivateUser->name = 'reactivate-users';
		$reactivateUser->display_name = 'Re-Activate Users';
		$reactivateUser->system = true;
		$reactivateUser->group_id = 3;
		$reactivateUser->sort = 11;
		$reactivateUser->created_at = Carbon::now();
		$reactivateUser->updated_at = Carbon::now();
		$reactivateUser->save();

		$permission_model = config('access.permission');
		$unbanUser = new $permission_model;
		$unbanUser->name = 'unban-users';
		$unbanUser->display_name = 'Un-Ban Users';
		$unbanUser->system = true;
		$unbanUser->group_id = 3;
		$unbanUser->sort = 12;
		$unbanUser->created_at = Carbon::now();
		$unbanUser->updated_at = Carbon::now();
		$unbanUser->save();

		$permission_model = config('access.permission');
		$undeleteUser = new $permission_model;
		$undeleteUser->name = 'undelete-users';
		$undeleteUser->display_name = 'Restore Users';
		$undeleteUser->system = true;
		$undeleteUser->group_id = 3;
		$undeleteUser->sort = 13;
		$undeleteUser->created_at = Carbon::now();
		$undeleteUser->updated_at = Carbon::now();
		$undeleteUser->save();

		$permission_model = config('access.permission');
		$permanentlyDeleteUser = new $permission_model;
		$permanentlyDeleteUser->name = 'permanently-delete-users';
		$permanentlyDeleteUser->display_name = 'Permanently Delete Users';
		$permanentlyDeleteUser->system = true;
		$permanentlyDeleteUser->group_id = 3;
		$permanentlyDeleteUser->sort = 14;
		$permanentlyDeleteUser->created_at = Carbon::now();
		$permanentlyDeleteUser->updated_at = Carbon::now();
		$permanentlyDeleteUser->save();

		$permission_model = config('access.permission');
		$resendConfirmationEmail = new $permission_model;
		$resendConfirmationEmail->name = 'resend-user-confirmation-email';
		$resendConfirmationEmail->display_name = 'Resend Confirmation E-mail';
		$resendConfirmationEmail->system = true;
		$resendConfirmationEmail->group_id = 3;
		$resendConfirmationEmail->sort = 15;
		$resendConfirmationEmail->created_at = Carbon::now();
		$resendConfirmationEmail->updated_at = Carbon::now();
		$resendConfirmationEmail->save();

		/**
		 * Role
		 */
		$permission_model = config('access.permission');
		$createRoles = new $permission_model;
		$createRoles->name = 'create-roles';
		$createRoles->display_name = 'Create Roles';
		$createRoles->system = true;
		$createRoles->group_id = 4;
		$createRoles->sort = 2;
		$createRoles->created_at = Carbon::now();
		$createRoles->updated_at = Carbon::now();
		$createRoles->save();

		$permission_model = config('access.permission');
		$editRoles = new $permission_model;
		$editRoles->name = 'edit-roles';
		$editRoles->display_name = 'Edit Roles';
		$editRoles->system = true;
		$editRoles->group_id = 4;
		$editRoles->sort = 3;
		$editRoles->created_at = Carbon::now();
		$editRoles->updated_at = Carbon::now();
		$editRoles->save();

		$permission_model = config('access.permission');
		$deleteRoles = new $permission_model;
		$deleteRoles->name = 'delete-roles';
		$deleteRoles->display_name = 'Delete Roles';
		$deleteRoles->system = true;
		$deleteRoles->group_id = 4;
		$deleteRoles->sort = 4;
		$deleteRoles->created_at = Carbon::now();
		$deleteRoles->updated_at = Carbon::now();
		$deleteRoles->save();

		/**
		 * Permission Group
		 */
		$permission_model = config('access.permission');
		$createPermissionGroups = new $permission_model;
		$createPermissionGroups->name = 'create-permission-groups';
		$createPermissionGroups->display_name = 'Create Permission Groups';
		$createPermissionGroups->system = true;
		$createPermissionGroups->group_id = 5;
		$createPermissionGroups->sort = 1;
		$createPermissionGroups->created_at = Carbon::now();
		$createPermissionGroups->updated_at = Carbon::now();
		$createPermissionGroups->save();

		$permission_model = config('access.permission');
		$editPermissionGroups = new $permission_model;
		$editPermissionGroups->name = 'edit-permission-groups';
		$editPermissionGroups->display_name = 'Edit Permission Groups';
		$editPermissionGroups->system = true;
		$editPermissionGroups->group_id = 5;
		$editPermissionGroups->sort = 2;
		$editPermissionGroups->created_at = Carbon::now();
		$editPermissionGroups->updated_at = Carbon::now();
		$editPermissionGroups->save();

		$permission_model = config('access.permission');
		$deletePermissionGroups = new $permission_model;
		$deletePermissionGroups->name = 'delete-permission-groups';
		$deletePermissionGroups->display_name = 'Delete Permission Groups';
		$deletePermissionGroups->system = true;
		$deletePermissionGroups->group_id = 5;
		$deletePermissionGroups->sort = 3;
		$deletePermissionGroups->created_at = Carbon::now();
		$deletePermissionGroups->updated_at = Carbon::now();
		$deletePermissionGroups->save();

		$permission_model = config('access.permission');
		$sortPermissionGroups = new $permission_model;
		$sortPermissionGroups->name = 'sort-permission-groups';
		$sortPermissionGroups->display_name = 'Sort Permission Groups';
		$sortPermissionGroups->system = true;
		$sortPermissionGroups->group_id = 5;
		$sortPermissionGroups->sort = 4;
		$sortPermissionGroups->created_at = Carbon::now();
		$sortPermissionGroups->updated_at = Carbon::now();
		$sortPermissionGroups->save();

		/**
		 * Permission
		 */
		$permission_model = config('access.permission');
		$createPermissions = new $permission_model;
		$createPermissions->name = 'create-permissions';
		$createPermissions->display_name = 'Create Permissions';
		$createPermissions->system = true;
		$createPermissions->group_id = 5;
		$createPermissions->sort = 5;
		$createPermissions->created_at = Carbon::now();
		$createPermissions->updated_at = Carbon::now();
		$createPermissions->save();

		$permission_model = config('access.permission');
		$editPermissions = new $permission_model;
		$editPermissions->name = 'edit-permissions';
		$editPermissions->display_name = 'Edit Permissions';
		$editPermissions->system = true;
		$editPermissions->group_id = 5;
		$editPermissions->sort = 6;
		$editPermissions->created_at = Carbon::now();
		$editPermissions->updated_at = Carbon::now();
		$editPermissions->save();

		$permission_model = config('access.permission');
		$deletePermissions = new $permission_model;
		$deletePermissions->name = 'delete-permissions';
		$deletePermissions->display_name = 'Delete Permissions';
		$deletePermissions->system = true;
		$deletePermissions->group_id = 5;
		$deletePermissions->sort = 7;
		$deletePermissions->created_at = Carbon::now();
		$deletePermissions->updated_at = Carbon::now();
		$deletePermissions->save();

        /**
         * Permission
         */

        /**
         * Subscriptions
         */
        $permission_model = config('access.permission');
        $viewSubscriptions = new $permission_model;
        $viewSubscriptions->name = 'list-subscriptions';
        $viewSubscriptions->display_name = 'View Subscription Plans';
        $viewSubscriptions->system = true;
        $viewSubscriptions->group_id = 6;
        $viewSubscriptions->sort = 1;
        $viewSubscriptions->created_at = Carbon::now();
        $viewSubscriptions->updated_at = Carbon::now();
        $viewSubscriptions->save();

        $permission_model = config('access.permission');
        $viewSubscriptions = new $permission_model;
        $viewSubscriptions->name = 'edit-subscription-plan';
        $viewSubscriptions->display_name = 'Edit Subscription Plan';
        $viewSubscriptions->system = true;
        $viewSubscriptions->group_id = 6;
        $viewSubscriptions->sort = 2;
        $viewSubscriptions->created_at = Carbon::now();
        $viewSubscriptions->updated_at = Carbon::now();
        $viewSubscriptions->save();

        /**
         * Subscriptions
         */

		if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
