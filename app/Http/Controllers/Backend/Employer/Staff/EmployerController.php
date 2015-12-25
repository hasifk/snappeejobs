<?php

namespace App\Http\Controllers\Backend\Employer\Staff;

use App\Http\Requests\Backend\Employer\Staff\CreateEmployerRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Employer\EloquentStaffRepository;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmployerController extends Controller
{

    /**
     * @var EloquentStaffRepository
     */
    private $staffs;
    /**
     * @var RoleRepositoryContract
     */
    private $roles;
    /**
     * @var PermissionRepositoryContract
     */
    private $permissions;

    /**
     * EmployerController constructor.
     * @param EloquentStaffRepository $staffs
     * @param RoleRepositoryContract $roles
     * @param PermissionRepositoryContract $permissions
     */
    public function __construct(EloquentStaffRepository $staffs, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions)
    {

        $this->staffs = $staffs;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Display a listing of the employer staffs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.employer.staff.index')
            ->withUsers($this->staffs->getUsersPaginated(config('access.users.default_per_page'), 1));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('backend.employer.staff.create')
//            ->withRoles($this->roles->getEmployerRoles('sort', 'asc', true));
//            ->withPermissions($this->permissions->getAllPermissions());
        return view('backend.employer.staff.create')
            ->withRoles($this->roles->getEmployerRoles('sort', 'asc', true))
            ->withPermissions([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployerRequest $request)
    {
        $this->staffs->create(
            $request->except('assignees_roles', 'permission_user'),
            $request->only('assignees_roles'),
            ['permission_user' => []]
        );

        return redirect()->route('admin.employer.staffs.index')->withFlashSuccess(trans("alerts.users.created"));
    }

    /**
     * @param $id
     * @param $status
     * @param MarkEmployerRequest $request
     * @return mixed
     */
    public function mark($id, $status, Requests\Backend\Employer\Staff\MarkEmployerRequest $request) {
        $this->staffs->mark($id, $status);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
    }


    /**
     * @param $id
     * @param PermanentlyDeleteEmployerRequest $request
     * @return mixed
     */
    public function delete($id, Requests\Backend\Employer\Staff\DeleteEmployerRequest $request) {
        $this->staffs->delete($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted_permanently"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Requests\Backend\Employer\Staff\UpdateEmployerViewRequest $request)
    {
        $user = $this->staffs->findOrThrowException($id, true);
        return view('backend.employer.staff.edit')
            ->withUser($user)
            ->withUserRoles($user->roles->lists('id')->all())
            ->withRoles($this->roles->getEmployerRoles('sort', 'asc', true))
            ->withUserPermissions($user->permissions->lists('id')->all())
            ->withPermissions($this->permissions->getAllPermissions());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\Backend\Employer\Staff\EditEmployerRequest $request, $id)
    {
        $this->staffs->update($id,
            $request->except('assignees_roles', 'permission_user'),
            $request->only('assignees_roles'),
            ['permission_user' => []]
        );
        return redirect()->route('admin.employer.staffs.index')->withFlashSuccess(trans("alerts.users.updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Requests\Backend\Employer\Staff\DeleteEmployerRequest $request)
    {
        $this->staffs->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted"));
    }

    public function deactivated() {
        return view('backend.employer.staff.deactivated')
            ->withUsers($this->staffs->getUsersPaginated(25, 0));
    }

    /**
     * @return mixed
     */
    public function deleted() {
        return view('backend.employer.staff.deleted')
            ->withUsers($this->staffs->getDeletedUsersPaginated(25));
    }

    /**
     * @return mixed
     */
    public function banned() {
        return view('backend.employer.staff.banned')
            ->withUsers($this->staffs->getUsersPaginated(25, 2));
    }

    /**
     * @param $id
     * @param ChangeEmployerPasswordViewRequest $request
     * @return mixed
     */
    public function changePassword($id, Requests\Backend\Employer\Staff\ChangeEmployerPasswordViewRequest $request) {
        return view('backend.employer.staff.change-password')
            ->withUser($this->staffs->findOrThrowException($id));
    }

    /**
     * @param $id
     * @param UpdateEmployerPasswordRequest $request
     * @return mixed
     */
    public function updatePassword($id, Requests\Backend\Employer\Staff\UpdateEmployerPasswordRequest $request) {
        $this->staffs->updatePassword($id, $request->all());
        return redirect()->route('admin.employer.staffs.index')->withFlashSuccess(trans("alerts.users.updated_password"));
    }

}
