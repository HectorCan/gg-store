<?php

namespace App\Http\Controllers\Maintenance\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Datatables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $params['perms'] = Permission::select('id', 'name')->get();
        return view('maintenance.user.role')->with($params);
    }

    public function dt(Request $request)
    {
        $Query = Role::select('roles.*', DB::raw('GROUP_CONCAT(permissions.id) as perms'))
            ->leftJoin('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
            ->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->groupBy('roles.id');

        return Datatables::of($Query)->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:100',
            'perms' => 'required'
        ]);

        if (!$validator->fails()) {
            $exists = Role::where('name', $request->input('name'))->count();

            if ($exists < 1) {
                $Role = Role::create(['name' => $request->input('name')]);

                if (!is_null($Role)) {
                    $Permissions = DB::table('permissions')
                        ->whereIn('id', $request->input('perms'))
                        ->get();

                    DB::table('role_has_permissions')
                        ->where('role_id', $Role->id)
                        ->whereNotIn('permission_id', $request->input('perms'))
                        ->delete();

                    foreach($Permissions as $permission) {
                        $d = ['role_id' => $Role->id, 'permission_id' => $permission->id];

                        DB::table('role_has_permissions')->updateOrInsert($d, $d);
                    }

                    return Response()->json(['m' => 'Permission has been created'], 200);
                }

                return Response()->json(['m' => 'Error, try again later'], 422);
            }

            return Response()->json(['m' => 'Permission with that name exists'], 422);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
            'name' => 'required|string|max:100',
        ]);

        if (!$validator->fails()) {
            $Role = Role::find($request->input('id'));

            if (isset($Role->id)) {
                $Role->name = $request->input('name');
                $Role->save();

                $Permissions = DB::table('permissions')
                    ->whereIn('id', $request->input('perms'))
                    ->get();

                DB::table('role_has_permissions')
                    ->where('role_id', $Role->id)
                    ->whereNotIn('permission_id', $request->input('perms'))
                    ->delete();

                foreach($Permissions as $permission) {
                    $d = ['role_id' => $Role->id, 'permission_id' => $permission->id];

                    DB::table('role_has_permissions')->updateOrInsert($d, $d);
                }

                return Response()->json(['m' => 'Permission has been updated'], 200);
            }

            return Response()->json(['m' => 'There is no Permission with that id'], 422);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
        ]);

        if (!$validator->fails()) {
            $Permission = Role::find($request->input('id'));

            if (isset($Permission->id)) {
                return Response()->json(['d' => $Permission], 200);
            }

            return Response()->json(['m' => 'There is no Permission with that id'], 422);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
        ]);

        if (!$validator->fails()) {
            DB::table('role_has_permissions')
                ->where('role_id', $request->input('id'))
                ->delete();

            DB::table('model_has_roles')
                ->where('model_type', 'App\User')
                ->where('role_id', $request->input('id'))
                ->delete();

            Role::where('id', $request->input('id'))->delete();

            return Response()->json(['m' => 'Permission has been deleted'], 200);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }
}
