<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DataTables;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function manage_users()
    {

        $users = User::all()->except(Auth::id());
        return view('admin.manage-users')->with(array(
            'users' => $users,

        ));
    }

    public function dashboard()
    {

        return view('admin.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ridelist(Request $request)
    {
        //$owner = new Ride();
        $rides = Ride::get();

        if ($request->ajax()) {
            $data = Ride::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($ride) {

                    $actionbtn = '';
                    $actionbtn .= '<a  class=" btn rounded btn-secondary m-1 btn-sm" data-bs-toggle="modal" data-bs-target ="#updateride' .$ride->id.'">Edit</a>';

                    $actionbtn .= '<a  class=" btn rounded btn-danger m-1 btn-sm" data-bs-toggle="modal" data-bs-target ="#deleteride' .$ride->id.'">Delete</a>';

                    return $actionbtn;
                })
                ->addColumn('driver', function ($owner) {
                    return $owner->driver->username;
                })
                ->addColumn('start_time', function ($ride) {
                    return $ride->start_time.', '.$ride->start_day;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.manage-rides')->with(array(
            'rides' => $rides,

        ));
    }


    public function passgerList()
    {
        $pasngers = User::where('type', '=', 'passenger')->get();

        return view('admin.manage-passengers')->with(array(
            'pasngers' => $pasngers,
        ));
    }


    public function profileEdit()
    {
        $user = Auth()->User();
        return view('admin.edit-profile')->with(array(
            'user' => $user,
        ));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $user = Auth()->user();

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone_number = $request['phone'];

        $user->save();

        return back()->with('success', 'Update Was Succesfull!');
    }

    public function uBlock($id)
    {
        User::where('id', $id)
            ->update([
                'status' => '1',
            ]);
        return redirect()->back()
            ->with('success', 'user Blocked succesfully');
    }

    public function uUnblock($id)
    {
        User::where('id', $id)
            ->update([
                'status' => '0',
            ]);
        return redirect()->back()
            ->with('success', 'user Unblocked succesfully');
    }

    public function updateUser(Request $request)
    {
        $user = User::find($request->id);
        $user->update([
            'first_name' => $request->fname,
            'last_name' => $request->l_name,
            'type' => $request->role,
            'email' => $request->email,
            'phone_number' => $request->phone

        ]);

        return redirect()->back()
            ->with('success', 'Update Done succesfully');
    }

    public function changePassword(Request $request)
    {
        return view('admin.changePassword');
    }


    public function updatePassword(Request $request)
    {

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'comfirm_new_password' => ['same:new_password'],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "Password changed successfully!");
    }
}
