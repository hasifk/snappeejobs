<?php namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\EditUserRequest;
use App\Http\Requests\Backend\Access\User\MarkUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Http\Requests\Backend\Access\User\DeleteUserRequest;
use App\Http\Requests\Backend\Access\User\RestoreUserRequest;
use App\Http\Requests\Backend\Access\User\ChangeUserPasswordRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Http\Requests\Backend\Access\User\PermanentlyDeleteUserRequest;
use App\Http\Requests\Backend\Access\User\ResendConfirmationEmailRequest;
use Activity;
/**
 * Class UserController
 */
class UserController extends Controller {

	/**
	 * @var UserContract
	 */
	protected $users;

	/**
	 * @var RoleRepositoryContract
	 */
	protected $roles;

	/**
	 * @var PermissionRepositoryContract
	 */
	protected $permissions;
    protected $userLogs;
	/**
	 * @param UserContract $users
	 * @param RoleRepositoryContract $roles
	 * @param PermissionRepositoryContract $permissions
	 */
	public function __construct(UserContract $users, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions,
LogsActivitysRepository $userLogs) {
		$this->users = $users;
		$this->roles = $roles;
		$this->permissions = $permissions;
        $this->userLogs = $userLogs;
	}

	/**
	 * @return mixed
	 */
	public function index() {
		return view('backend.access.index')
			->withUsers($this->users->getUsersPaginated(config('access.users.default_per_page'), 1));
	}

	/**
	 * @param CreateUserRequest $request
	 * @return mixed
     */
	public function create(CreateUserRequest $request) {
		return view('backend.access.create')
			->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withPermissions($this->permissions->getAllPermissions());
	}

	/**
	 * @param StoreUserRequest $request
	 * @return mixed
     */
	public function store(StoreUserRequest $request) {
        $array['type'] = 'User';
        $array['heading']='Name:'.$request->name;
		if($this->users->create(
			$request->except('assignees_roles', 'permission_user'),
			$request->only('assignees_roles'),
			$request->only('permission_user')
		))
        {
            $array['event'] = 'created';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.created"));
	}

	/**
	 * @param $id
	 * @param EditUserRequest $request
	 * @return mixed
     */
	public function edit($id, EditUserRequest $request) {
		$user = $this->users->findOrThrowException($id, true);
		return view('backend.access.edit')
			->withUser($user)
			->withUserRoles($user->roles->lists('id')->all())
			->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withUserPermissions($user->permissions->lists('id')->all())
			->withPermissions($this->permissions->getAllPermissions());
	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 * @return mixed
	 */
	public function update($id, UpdateUserRequest $request) {
        $user =User::find($id);
        $array['type'] = 'User';
        $array['heading']='With name:'.$user->name;
		if($this->users->update($id,
			$request->except('assignees_roles', 'permission_user','age'),
			$request->only('assignees_roles'),
			$request->only('permission_user')
		))
        {
            $array['event'] = 'updated';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @param $id
	 * @param DeleteUserRequest $request
	 * @return mixed
     */
	public function destroy($id, DeleteUserRequest $request) {
        $user =User::find($id);
        $array['type'] = 'User';
        $array['heading']='With name:'.$user->name;
		if($this->users->destroy($id))
        {
            $array['event'] = 'deleted';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted"));
	}

	/**
	 * @param $id
	 * @param PermanentlyDeleteUserRequest $request
	 * @return mixed
     */
	public function delete($id, PermanentlyDeleteUserRequest $request) {
        $user =User::withTrashed()->find($id);
        $array['type'] = 'User';
        $array['heading']='With name:'.$user->name;
		if($this->users->delete($id))
        {
            $array['event'] = 'permanentlydeleted';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted_permanently"));
	}

	/**
	 * @param $id
	 * @param RestoreUserRequest $request
	 * @return mixed
     */
	public function restore($id, RestoreUserRequest $request) {
        $user =User::withTrashed()->find($id);
        $array['type'] = 'User';
        $array['heading']='With name:'.$user->name.'is restored';
		if($this->users->restore($id))
        {
            $array['event'] = 'restored';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->back()->withFlashSuccess(trans("alerts.users.restored"));
	}

	/**
	 * @param $id
	 * @param $status
	 * @param MarkUserRequest $request
	 * @return mixed
     */
	public function mark($id, $status, MarkUserRequest $request) {
        $user =User::find($id);
        $array['type'] = 'User';
        $array['heading']='With name:'.$user->name;
		if($this->users->mark($id, $status))
        {
            $array['event'] = 'updated';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @return mixed
	 */
	public function deactivated() {
		return view('backend.access.deactivated')
			->withUsers($this->users->getUsersPaginated(25, 0));
	}

	/**
	 * @return mixed
	 */
	public function deleted() {
		return view('backend.access.deleted')
			->withUsers($this->users->getDeletedUsersPaginated(25));
	}

	/**
	 * @return mixed
	 */
	public function employers() {
		return view('backend.access.employers')
			->withUsers($this->users->getEmployersPaginated(25));
	}

	/**
	 * @return mixed
	 */
	public function banned() {
		return view('backend.access.banned')
			->withUsers($this->users->getUsersPaginated(25, 2));
	}

	/**
	 * @param $id
	 * @param ChangeUserPasswordRequest $request
	 * @return mixed
     */
	public function changePassword($id, ChangeUserPasswordRequest $request) {
		return view('backend.access.change-password')
			->withUser($this->users->findOrThrowException($id));
	}

	/**
	 * @param $id
	 * @param UpdateUserPasswordRequest $request
	 * @return mixed
	 */
	public function updatePassword($id, UpdateUserPasswordRequest $request) {
        $user =User::find($id);
        $array['type'] = 'User';
        $array['heading']='With name:'.$user->name.':password';
		if($this->users->updatePassword($id, $request->all()))
        {
            $array['event'] = 'updated';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }
		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated_password"));
	}

	/**
	 * @param $user_id
	 * @param AuthenticationContract $auth
	 * @param ResendConfirmationEmailRequest $request
	 * @return mixed
     */
	public function resendConfirmationEmail($user_id, AuthenticationContract $auth, ResendConfirmationEmailRequest $request) {
		$auth->resendConfirmationEmail($user_id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.confirmation_email"));
	}
}