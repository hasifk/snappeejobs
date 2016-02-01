<?php namespace App\Repositories\Backend\Job;

use App\Events\Backend\Job\JobCreated;
use App\Models\Access\User\User;
use App\Exceptions\GeneralException;
use App\Models\Job\Job;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Exceptions\Backend\Access\User\UserNeedsRolesException;
use Event;
use Illuminate\Auth\Guard;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentJobRepository {

	/**
	 * @var RoleRepositoryContract
	 */
	protected $role;

	/**
	 * @var AuthenticationContract
	 */
	protected $auth;
    private $companyId;
    /**
     * @var Guard
     */
    private $user;

    /**
     * @param RoleRepositoryContract $role
     * @param AuthenticationContract $auth
     * @param Guard $user
     */
	public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth, Guard $user) {
		$this->role = $role;
		$this->auth = $auth;
        $this->user = $user;
        $this->companyId = $this->user->user() ? $this->user->user()->employerCompany->id : null;
    }

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$job = Job::where('company_id', $this->companyId)->find($id);
		if (! is_null($job)) return $job;

		throw new GeneralException('That job does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param int $status
	 * @return mixed
	 */
	public function getJobsPaginated($per_page, $status = 1, $order_by = 'jobs.id', $sort = 'asc') {
		return Job::where('company_id', $this->companyId)->orderBy($order_by, $sort)
            ->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedJobsPaginated($per_page) {
		return Job::where('company_id', $this->companyId)->onlyTrashed()->paginate($per_page);
	}

	public function getDisabledJobsPaginated($per_page) {
		return Job::where('company_id', $this->companyId)->where('status', 0)->paginate($per_page);
	}

	public function getHiddenJobsPaginated($per_page) {
		return Job::where('company_id', $this->companyId)->where('published', 0)->paginate($per_page);
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
	public function create($input) {

		$job = $this->createJobStub($input);

		if ($job->save()) {

			//Attach new job categories
			$job->attachCategories($input['job_category']);
			$job->attachSkills($input['skills']);
			$job->attachPrerequisites($input['prerequisites']);

            Event::fire(new JobCreated($job, auth()->user() ));

			return true;
		}

		throw new GeneralException('There was a problem creating this job. Please try again.');
	}

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
	 * @return bool
	 * @throws GeneralException
	 */
	public function update($id, $input) {
		$job = $this->findOrThrowException($id);

		$job = $this->updateJobStub($job, $input);

		if ( $job->save() ) {

			//Update new job categories
			$job->detachCategories();
			$job->attachCategories($input['job_category']);

			//Update new job skills
			$job->detachSkills();
			$job->attachSkills($input['skills']);

			//Update new job prerequisites
			$job->detachPrerequisites();
			$job->attachPrerequisites($input['prerequisites']);

			return true;
		}

		throw new GeneralException('There was a problem updating this job. Please try again.');
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

		$job = $this->findOrThrowException($id);
		if ($job->delete())
			return true;

		throw new GeneralException("There was a problem deleting this user. Please try again.");
	}

	/**
	 * @param $id
	 * @return boolean|null
	 * @throws GeneralException
	 */
	public function delete($id) {
		$job = $this->findOrThrowException($id);

		//Detach all roles & permissions
		$job->detachCategories();
		$job->detachPrerequisites();

		try {
			$job->forceDelete();
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
		$job = $this->findOrThrowException($id);
		$job->status = $status;

		if ($job->save())
			return true;

		throw new GeneralException("There was a problem updating this job. Please try again.");
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function publish($id) {
		$job = $this->findOrThrowException($id);
		$job->published = true;

		if ($job->save())
			return true;

		throw new GeneralException("There was a problem updating this job. Please try again.");
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function hide($id) {
		$job = $this->findOrThrowException($id);
		$job->published = false;

		if ($job->save())
			return true;

		throw new GeneralException("There was a problem updating this job. Please try again.");
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
	private function createJobStub($input)
	{
		$job = new Job;

		$url_slug = str_slug($input['title'], '-') ? str_slug($input['title'], '-') : $this->slugify($input['title']);

		$job->company_id           = $this->companyId;
		$job->title                = $input['title'];
		$job->title_url_slug       = $url_slug;
		$job->level                = $input['level'];
		$job->country_id           = $input['country_id'];
		$job->state_id             = $input['state_id'];
		$job->likes                = 0;
		$job->status               = false;
		$job->published            = $input['published'] ? true : false;
		$job->description          = $input['description'];
		return $job;
	}

	private function updateJobStub($job, $input)
	{
		$url_slug = str_slug($input['title'], '-') ? str_slug($input['title'], '-') : $this->slugify($input['title']);

		$job->company_id           = $this->companyId;
		$job->title                = $input['title'];
		$job->title_url_slug       = $url_slug;
		$job->level                = $input['level'];
		$job->country_id           = $input['country_id'];
		$job->state_id             = $input['state_id'];
		$job->description          = $input['description'];
        $job->published            = $input['published'] ? true : false;
		return $job;
	}

	public function slugify($text)
	{
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		// trim
		$text = trim($text, '-');
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		// lowercase
		$text = strtolower($text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		if (empty($text))
		{
			return 'n-a';
		}

		return $text;
	}
}
