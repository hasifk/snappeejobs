<?php

namespace App\Http\Controllers\Backend\Employer\Staff;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
