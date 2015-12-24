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
    public function edit($id)
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
    public function destroy($id)
    {
        //
    }
}
