<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;

use App\Models\Vehicle;
use App\Models\Ride;
use App\Models\User;

use DataTables;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function vehiclesList(Request $request)

    {
        $type = new Vehicle();
        $cartype =  $type->getvehicleType();
        $vehicles = Vehicle::orderby('id', 'desc')->get();

        if ($request->ajax()) {
            $data = Vehicle::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('owner', function($vehicle){
                    return $vehicle->owner->username;
                })
                ->addColumn('action', function($vehicle){
                    $actionbtn = '';
                    $actionbtn .= '<a  class=" btn rounded btn-secondary m-1 btn-sm" data-bs-toggle="modal" data-bs-target ="#updatevehicle' .$vehicle->id.'">Edit</a>';

                    $actionbtn .= '<a  class=" btn rounded btn-danger m-1 btn-sm" data-bs-toggle="modal" data-bs-target ="#deletevehicle' .$vehicle->id.'">Delete</a>';

                    return $actionbtn;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.manage-vehicle')->with(array(
            'vehicles' => $vehicles,
            'cartype' => $cartype,
            'type' => $type,

        ));


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
     * @param  \App\Http\Requests\StoreVehicleRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {   
        
        //$image = $imageName = time().'.'.$request->image->getClientOriginalName();

        // Public Folder
        //$request->image->move(public_path('uploads/avatars'), $imageName);
       
        $vehicle = Vehicle::create([
            'name' => $request->name,
            'plate_number' => $request->plate_no,
            'num_of_seats' => $request->no_seats,
            'cost_per_seat' => $request->cost_seat,
            'cost' => $request->cost,
            'brand' => $request->brand,
            'color' => $request->color,
            'type' => $request->type,
            'description' => $request->descriptn,
            //'image' => $image,
            'owner_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Vehicle Created Succesfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleRequest  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}