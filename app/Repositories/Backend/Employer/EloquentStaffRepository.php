<?php namespace App\Repositories\Backend\Employer;

use App\Events\Backend\Account\UserCreated;
use App\Models\Access\User\User;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Exceptions\Backend\Access\User\UserNeedsRolesException;
use Carbon\Carbon;
use Event;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentStaffRepository {

	/**
	 * @var RoleRepositoryContract
	 */
	protected $role;

	/**
	 * @var AuthenticationContract
	 */
	protected $auth;

	/**
	 * @param RoleRepositoryContract $role
	 * @param AuthenticationContract $auth
	 */
	public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth) {
		$this->role = $role;
		$this->auth = $auth;
	}

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id, $withRoles = false) {
		if ($withRoles)
			$user = User::with('roles')->withTrashed()->find($id);
		else
			$user = User::withTrashed()->find($id);

		if (! is_null($user)) return $user;

		throw new GeneralException('That user does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param int $status
	 * @return mixed
	 */
	public function getUsersPaginated($per_page, $status = 1, $order_by = 'users.id', $sort = 'asc') {
		return User::join('staff_employer', 'staff_employer.user_id', '=', 'users.id')
            ->where('users.status', $status)
            ->where('staff_employer.employer_id', auth()->user()->id)
            ->select(['users.*'])
            ->orderBy($order_by, $sort)
            ->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUsersPaginated($per_page) {
		return User::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUsers($order_by = 'id', $sort = 'asc') {
		return User::orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $input
	 * @param $roles
	 * @param $permissions
	 * @return bool
	 * @throws GeneralException
	 * @throws UserNeedsRolesException
	 */
	public function create($input, $roles, $permissions) {
		$user = $this->createUserStub($input);

		if ($user->save()) {
			//User Created, Validate Roles
			$this->validateRoleAmount($user, $roles['assignees_roles']);

			//Attach new roles
			$user->attachRoles($roles['assignees_roles']);

			//Attach other permissions
			$user->attachPermissions($permissions['permission_user']);

            Event::fire(new UserCreated($user, auth()->user() ));

			//Send confirmation email if requested
			if (isset($input['confirmation_email']) && $user->confirmed == 0)
				$this->auth->resendConfirmationEmail($user->id);

			return true;
		}

		throw new GeneralException('There was a problem creating this user. Please try again.');
	}

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
	 * @return bool
	 * @throws GeneralException
	 */
	public function update($id, $input, $roles, $permissions) {
		$user = $this->findOrThrowException($id);
		$this->checkUserByEmail($input, $user);

		if ($user->update($input)) {
			//For whatever reason this just wont work in the above call, so a second is needed for now
			$user->status = isset($input['status']) ? 1 : 0;
			$user->confirmed = isset($input['confirmed']) ? 1 : 0;
			$user->save();

			$this->checkUserRolesCount($roles);
			$this->flushRoles($roles, $user);
			$this->flushPermissions($permissions, $user);

			Event::fire(new UserCreated($user, auth()->user() ));

			return true;
		}

		throw new GeneralException('There was a problem updating this user. Please try again.');
	}

	/**
	 * @param $id
	 * @param $input
	 * @return bool
	 * @throws GeneralException
	 */
	public function updatePassword($id, $input) {
		$user = $this->findOrThrowException($id);

		//Passwords are hashed on the model
		$user->password = $input['password'];
		if ($user->save())
			return true;

		throw new GeneralException('There was a problem changing this users password. Please try again.');
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function destroy($id) {
		if (auth()->id() == $id)
			throw new GeneralException("You can not delete yourself.");

		$user = $this->findOrThrowException($id);
		if ($user->delete())
			return true;

		throw new GeneralException("There was a problem deleting this user. Please try again.");
	}

	/**
	 * @param $id
	 * @return boolean|null
	 * @throws GeneralException
	 */
	public function delete($id) {
		$user = $this->findOrThrowException($id, true);

		//Detach all roles & permissions
		$user->detachRoles($user->roles);
		$user->detachPermissions($user->permissions);

		try {
			if($user->forceDelete())
				return true;
		} catch (\Exception $e) {
			throw new GeneralException($e->getMessage());
		}
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function restore($id) {
		$user = $this->findOrThrowException($id);

		if ($user->restore())
			return true;

		throw new GeneralException("There was a problem restoring this user. Please try again.");
	}

	/**
	 * @param $id
	 * @param $status
	 * @return bool
	 * @throws GeneralException
	 */
	public function mark($id, $status) {
		if (auth()->id() == $id && ($status == 0 || $status == 2))
			throw new GeneralException("You can not do that to yourself.");

		$user = $this->findOrThrowException($id);
		$user->status = $status;

		if ($user->save())
			return true;

		throw new GeneralException("There was a problem updating this user. Please try again.");
	}

	/**
	 * Check to make sure at lease one role is being applied or deactivate user
	 * @param $user
	 * @param $roles
	 * @throws UserNeedsRolesException
	 */
	private function validateRoleAmount($user, $roles) {
		//Validate that there's at least one role chosen, placing this here so
		//at lease the user can be updated first, if this fails the roles will be
		//kept the same as before the user was updated
		if (count($roles) == 0) {
			//Deactivate user
			$user->status = 0;
			$user->save();

			$exception = new UserNeedsRolesException();
			$exception->setValidationErrors('You must choose at lease one role. User has been created but deactivated.');

			//Grab the user id in the controller
			$exception->setUserID($user->id);
			throw $exception;
		}
	}

    public function getPlanDetails(User $user){
        $employer_id = $this->getemployerId($user);
        return \DB::table('employer_plan')->where('employer_id', $employer_id)->first();
    }

    public function getemployerId(User $user){
        $employer_id = \DB::table('staff_employer')
            ->where('user_id', $user->id)
            ->where('is_admin', true)
            ->orderBy('created_at')
            ->value('employer_id');
        return $employer_id;
    }

	public function employerPlanSave($plan, User $user){
        $employer_id = $this->getemployerId($user);

        $employer_plan_exists = \DB::table('employer_plan')->where('employer_id', $employer_id)->count();
        if ( $employer_plan_exists ) {

            $plan_details = \DB::table('employer_plan')->where('employer_id', $employer_id)->first();

            \DB::table('employer_plan')->where('employer_id', $employer_id)
                ->update([
                    'job_postings'      => ( $plan_details['job_postings'] + $plan['addons']['job_postings']['count'] ),
                    'staff_members'     => ( $plan_details['staff_members'] + $plan['addons']['staff_members']['count'] ),
                    'chats_accepted'    => ( $plan_details['chats_accepted'] + $plan['addons']['chats_accepted']['count'] ),
                    'updated_at'        => Carbon::now()
                ]);

        } else {
            \DB::table('employer_plan')->insert([
                'employer_id'       => $employer_id,
                'job_postings'      => $plan['addons']['job_postings']['count'],
                'staff_members'     => $plan['addons']['staff_members']['count'],
                'chats_accepted'    => $plan['addons']['chats_accepted']['count'],
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }
	}
	
	/**
	 * @param $input
	 * @param $user
	 * @throws GeneralException
	 */
	private function checkUserByEmail($input, $user)
	{
		//Figure out if email is not the same
		if ($user->email != $input['email'])
		{
			//Check to see if email exists
			if (User::where('email', '=', $input['email'])->first())
				throw new GeneralException('That email address belongs to a different user.');
		}
	}

	/**
	 * @param $roles
	 * @param $user
	 */
	private function flushRoles($roles, $user)
	{
		//Flush roles out, then add array of new ones
		$user->detachRoles($user->roles);
		$user->attachRoles($roles['assignees_roles']);
	}

	/**
	 * @param $permissions
	 * @param $user
	 */
	private function flushPermissions($permissions, $user)
	{
		//Flush permissions out, then add array of new ones if any
		$user->detachPermissions($user->permissions);
		if (count($permissions['permission_user']) > 0)
			$user->attachPermissions($permissions['permission_user']);
	}

	/**
	 * @param $roles
	 * @throws GeneralException
	 */
	private function checkUserRolesCount($roles)
	{
		//User Updated, Update Roles
		//Validate that there's at least one role chosen
		if (count($roles['assignees_roles']) == 0)
			throw new GeneralException('You must choose at least one role.');
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	private function createUserStub($input)
	{
		$user = new User;
		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->password = $input['password'];
		$user->gender = $input['gender'];
		$user->dob = (!empty($input['dob'])) ? new Carbon($input['dob']) : '';
		$user->country_id=auth()->user()->country_id;
        $user->state_id=auth()->user()->state_id;
		$user->status = isset($input['status']) ? 1 : 0;
		$user->confirmation_code = md5(uniqid(mt_rand(), true));
		$user->confirmed = isset($input['confirmed']) ? 1 : 0;
		return $user;
	}
}
