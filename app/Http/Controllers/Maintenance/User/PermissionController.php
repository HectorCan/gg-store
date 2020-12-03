<?php

namespace App\Http\Controllers\Maintenance\User;

use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Datatables;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('maintenance.user.permission');
    }

    public function dt(Request $request)
    {
        return Datatables::of(Permission::query())->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        if (!$validator->fails()) {
            $exists = Permission::where('name', $request->input('name'))->count();

            if ($exists < 1) {
                $Permission = Permission::create(['name' => $request->input('name')]);

                if (!is_null($Permission)) {
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
            $Permission = Permission::find($request->input('id'));

            if (isset($Permission->id)) {
                $Permission->name = $request->input('name');
                $Permission->save();

                return Response()->json(['m' => 'Permission has been updated'], 200);
            }

            return Response()->json(['m' => 'There is no Permission with that id'], 422);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if (!$validator->fails()) {
            $Permission = Permission::find($request->input('id'));

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
            Permission::where('id', $request->input('id'))->delete();

            return Response()->json(['m' => 'Permission has been deleted'], 200);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }
}
