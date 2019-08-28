<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use App\User;
use Illuminate\Http\Request;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->role = $user->roles->first()->name;
            //$user->organization=DB::table('organizations')->where('organization_id', $user->organization_id)->first()->organization_name;
            $org = DB::table('organizations')->where('organization_id', $user->organization_id)->first()->organization_name;
            $user->organization = $org;

            if (!empty($user->country_id)) {
                $country = DB::table('recipients_country')->where('recipients_country_id', $user->country_id)->first()->country_name;
                $user->country = $country;
            } else {
                $user->country = 'N/A';
            }

            if (!empty($user->department_id)) {
                $dept = DB::table('departments')->where('department_id', $user->department_id)->first()->dept_name;
                $user->department = $dept;
            } else {
                $user->department = 'N/A';
            }
        }

        return view('admin.users.list')->with([
            'users' => $users,
            'current_user' => Auth::user()->id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        $organizations = DB::table('organizations')->get();
        $countries = DB::table('recipients_country')->pluck('country_name', 'recipients_country_id')->all();
        $departments = DB::table('departments')->pluck('dept_name', 'department_id')->all();

        $roles_array = [];
        foreach ($roles as $role) {
            $roles_array[$role->id] = $role->name;
        }


        $organizations_array = [];
        foreach ($organizations as $organization) {
            $organizations_array[$organization->organization_id] = $organization->organization_name;
        }


        return view('admin.users.create')->with([
            'roles' => $roles_array, 'organizations' => $organizations_array,
            'countries' => $countries, 'departments' => $departments
        ]);
        //return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'full_names' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = new User;

        $user->name = ucwords($request->input('full_names'));
        $user->telephone = $request->input('telephone');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->organization_id = $request->input('organization');
        $user->country_id = $request->input('country');
        $user->department_id = $request->input('department');

        $user->save();

        $user = User::find($user->id);

        $role = \Spatie\Permission\Models\Role::find($request->input('role'))->name;

        $user->assignRole($role);


        return redirect('admin/user')->with('success', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        $roles = \Spatie\Permission\Models\Role::all();
        $organizations = DB::table('organizations')->get();
        $countries = DB::table('recipients_country')->pluck('country_name', 'recipients_country_id')->all();
        $departments = DB::table('departments')->pluck('dept_name', 'department_id')->all();
        $departments1 = DB::table('departments')->orderBy('department_id', 'asc')->get();

        $roles_array = [];
        foreach ($roles as $role) {
            $roles_array[$role->id] = $role->name;
        }


        $organizations_array = [];
        foreach ($organizations as $organization) {
            $organizations_array[$organization->organization_id] = $organization->organization_name;
        }

        $user = User::findOrFail($id);
        $user->role_id = $user->roles->first()->id;

        return view('admin.users.edit', [
            'roles' => $roles_array, 'organizations' => $organizations_array,
            'user' => $user, 'countries' => $countries, 'departments' => $departments, 'departments1' => $departments1,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'full_names' => 'required',
            'email' => 'required|email',
            //'password'=>'min:6',
        ]);

        $user = User::findOrFail($id);



        $user->name = $request->input('full_names');
        $user->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->organization_id = $request->input('organization');
        $user->country_id = $request->input('country');
        $depts  = $request->input('department');
        $user->telephone = $request->input('telephone');

        $user->save();
        $updated_user = $user->id;

        $depts_ids = DB::table('user_departments_mapping')
            ->select(DB::raw('user_departments_mapping.*'))
            ->where('user_departments_mapping.user_id', '=', $updated_user)
            ->delete();

        $user_depts = array();
        foreach ($depts as $key => $value) {

            $save_user_depts = DB::table('user_departments_mapping')->insertGetId(['user_id' => $updated_user, 'mapping_dept_id' => $value]);
        }

        //$save_user_depts = DB::table('user_departments_mapping')->insertGetId($user_depts);







        $user->syncRoles($request->role);

        return redirect('admin/user')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/user')->with('success', 'User Deleted Successfully');;
    }
}