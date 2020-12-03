<?php

namespace App\Http\Controllers\Maintenance\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;
use Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('maintenance.user.user');
    }

    public function dt(Request $request)
    {
        $Query = User::query();

        return Datatables::of($Query)->make(true);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:100|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string',
            'cpassword' => 'required|same:password'
        ]);

        if (!$validator->fails()) {
            $User = User::create([
                'name'      => $request->input('name'),
                'username'  => $request->input('username'),
                'email'     => $request->input('email'),
                'password'  => Hash::make($request->input('password'))
            ]);

            if (isset($User->id)) {
                return Response()->json(['m' => 'User has been created'], 200);
            }

            return Response()->json(['m' => 'An error ocurred, try again later'], 422);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required|integer',
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:100|unique:users,username,'.$request->input('id'),
            'email'     => 'required|email|unique:users,email,'.$request->input('id'),
            'status'    => 'required|integer',
            'password'  => 'nullable|string',
            'cpassword' => 'required_with:password|same:password'
        ]);

        if (!$validator->fails()) {
            $User = User::find($request->input('id'));

            if (isset($User->id)) {
                $User->name      = $request->input('name');
                $User->username  = $request->input('username');
                $User->email     = $request->input('email');
                $User->statusId  = $request->input('status');

                if (!empty($request->input('password'))) {
                    $User->password = Hash::make($request->input('password'));
                }

                $User->save();

                return Response()->json(['m' => 'User has been updated'], 200);
            }

            return Response()->json(['m' => 'There is no user with that id'], 422);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function get()
    {

    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
        ]);

        if (!$validator->fails()) {
            User::where('id', $request->input('id'))->update([
                'statusId' => 0
            ]);

            return Response()->json(['m' => 'User has been disabled'], 200);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }
}
