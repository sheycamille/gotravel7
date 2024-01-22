    @extends('layouts.app')

    @section('title', 'My rides offered')

    @section('active')

    @section('sub-menu4', 'active')

    @section('content')

    @include('parts.small_header_extend')

    <style type="text/css">
        span, label{
            font-size:18px;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .mb-3 {
            margin-bottom: 7px;
        }

        .row:after {
        content: "";
        display: table;
        clear: both;
        }

        .column {
        float: left;
        width: 50%;
        padding: 10px;
        margin: 0px;
        }

        .modal label{
            font-weight: normal;
            margin-bottom: 0;
            font-size: 16px;
        }

        

        /*tr:nth-child(even) {
            background-color: #dddddd;
        }*/
    </style>

    <div class="main ">
        <div class="container">
            <div class="row">

                @include('parts.account_sidebar')

                <div class="col-sm-10">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">	
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                    @endif

                    <h1>My Vehicles</h1>

                    <hr class="hidden-xs">
                    <a class="btn btn-primary mb-3" onclick="$('#addvehicle').modal('show')">Add vehicle</a>

                    <table>
                        <thead>
                            <tr>
                                <th>Number plate</th>
                                <th>No of seats</th>
                                <th>Cost per seat</th>
                                <th>Vehicle type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                            <tr>
                                <td>{{$vehicle->plate_number}}</td>
                                <td>{{$vehicle->num_of_seats }}</td>
                                <td>{{$vehicle->cost_per_seat }}</td>
                                <td>{{$vehicle->type}}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editvehicle-{{$vehicle->id}}" >Edit</a>  <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletevehicle-{{$vehicle->id}}">Delete</a>
                                </td>
                            </tr>

                            <!-- edit vehicle modal -->
                            <div id="editvehicle-{{$vehicle->id}}" tabindex="-1" role="dialog" aria-spanledby="modal-login-span" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                <div class="modal-content col-md-10 col-md-offset-1">
            
                                    <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                    <h5  class="modal-title"> Edit Vehicle</h5>
                                    </div>
            
                                    <div class="modal-body">
                                    <div class="form" style="height: inherit;">
                                        <form class="form-horizontal row" action="{{ route('update-vehicle', $vehicle->id) }}" role="form" method="post">
                                        {{ csrf_field() }}
                                        
                                        <div class="row">
                                            <div class="column">
                                                <div class="">
                                                    <label for="name" class="form-label">Name</label>
                                                <input id="name" type="text" value="{{$vehicle->name}}" class="form-control " name="name" required>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="">
                                                    <label for="plate_no" class="form-label">Number plate</label>
                                                <input id="plate_number" type="text" value="{{$vehicle->plate_number}}" class="form-control" name="plate_no" required>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row">
                                            <div class="column" style="width: 100%;">
                                                <div class="">
                                                    <label for="image" class="form-label">Image</label>
                                                <input id="image" type="file" placeholder="vehicle image" class="form-control " name="image" >
                                                </div>
                                            </div> 
                                            
                                        </div>
            
                                        <div class="row">
                                            <div class="column" >
                                                <div class="">
                                                    <label for="prod_year" class="form-label">Production year</label>
                                                <input id="prod_year" type="text" value="{{$vehicle->prod_year}}" class="form-control " name="prod_year" required>
                                                </div>
                                            </div>
                                            <div class="column" >
                                                <div class="">
                                                    <label for="number_of_seats" class="form-label">No of seats</label>
                                                <input id="number_of_seats" type="text" value="{{$vehicle->num_of_seats}}" class="form-control " name="no_seats" required>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="">
                                                    <label for="cost_seat" class="form-label">Cost per seat</label>
                                                <input id="cost_seat" type="text" value="{{$vehicle->cost_per_seat}}" class="form-control " name="cost_seat" required>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="">
                                                    <label for="description" class="form-label">Description</label>
                                                <input id="description" type="text" value="{{$vehicle->description}}" class="form-control" name="descriptn" required>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row">
                                            <div class="column">
                                                <div class="">
                                                    <label for="color" class="form-label">Color</label>
                                                <input id="color" type="text" value="{{$vehicle->color}}" class="form-control" name="color" required>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="">
                                                    <label for="brand" class="form-label">Vehicle brand</label>
                                                <input id="brand" type="text" value="{{$vehicle->brand}}" class="form-control" name="brand" required>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="column" style="width: 100%;">
                                                <label for="type" class="form-label">Vehicle type</label>
                                                <select name="type" id="type" class="form-control">
                                                    @foreach($cartype as $car)
                                                    <option <?= $car == $vehicle->type ? 'selected' : '' ?>>{{$car}}</option>
                                                    @endforeach
                                                </select> 
                                            </div> 
                                            
                                        </div>
            
            
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-lg btn-primary pull-left">Update</button>
                                        </div>
                            
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <!--Delete vehicle Modal -->
                            <div class="modal fade" id="deletevehicle-{{$vehicle->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content col-md-10 col-md-offset-1">
                                    <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Vehicle</h5>
                                    
                                    </div>
                                    <div class="modal-body">
                                    <p>Are you sure you want to delete this vehicle?</p>
                                    </div>
                                    <div class="modal-footer">
                                    <form id="submit-form" action="{{ route('del_vehicle', $vehicle->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('POST')
                                    </form>
                                    <a  type="button" class="btn btn-danger " onclick="event.preventDefault(); document.getElementById('submit-form').submit();">Yes, i'm sure</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- delete vehicle modal -->
                            
                            @empty
                            Sorry you have not offered any rides on Gokamz, don't forget to list your next journey here, so you don't travel alone.<br><br>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Add vehicle Modal -->
                    <div id="addvehicle" tabindex="-1" role="dialog" aria-spanledby="modal-login-span" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog">
                        <div class="modal-content col-md-10 col-md-offset-1">

                            <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                            <h5  class="modal-title"> Add Vehicle</h5>
                            </div>

                            <div class="modal-body">
                            <div class="form" style="height: inherit;">
                                <form class="form-horizontal row" action="" role="form" method="post">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                    <div class="column">
                                        <div class="">
                                            <label for="name" class="form-label">Name</label>
                                        <input id="name" type="text" placeholder="name" class="form-control " name="name" required>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="">
                                            <label for="plate_no" class="form-label">Number plate</label>
                                        <input id="plate_number" type="text" placeholder="number plate" class="form-control" name="plate_no" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="column" style="width: 100%;">
                                        <div class="">
                                            <label for="image" class="form-label">Image</label>
                                        <input id="image" type="file" placeholder="vehicle image" class="form-control " name="image" >
                                        </div>
                                    </div> 
                                    
                                </div>

                                <div class="row">
                                    <div class="column" >
                                        <div class="">
                                            <label for="prod_year" class="form-label">Production year</label>
                                        <input id="prod_year" type="text" placeholder="production year" class="form-control " name="prod_year" required>
                                        </div>
                                    </div>
                                    <div class="column" >
                                        <div class="">
                                            <label for="number_of_seats" class="form-label">No of seats</label>
                                        <input id="number_of_seats" type="text" placeholder="no of seats" class="form-control " name="no_seats" required>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="">
                                            <label for="cost_seat" class="form-label">Cost per seat</label>
                                        <input id="cost_seat" type="text" placeholder="cost per seat" class="form-control " name="cost_seat" required>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="">
                                            <label for="description" class="form-label">Description</label>
                                        <input id="description" type="text" placeholder="description" class="form-control" name="descriptn" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="column">
                                        <div class="">
                                            <label for="color" class="form-label">Color</label>
                                        <input id="color" type="text" placeholder="color" class="form-control" name="color" required>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="">
                                            <label for="brand" class="form-label">Vehicle brand</label>
                                        <input id="brand" type="text" placeholder="brand" class="form-control" name="brand" required>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column" style="width: 100%;">
                                        <label for="type" class="form-label">Vehicle type</label>
                                        <select name="type" id="type" class="form-control">
                                            <option selected >select vehicle type</option>
                                            @foreach($cartype as $car)
                                            <option value="{{$car}}" >{{$car}}</option>
                                            @endforeach
                                        </select> 
                                    </div> 
                                    
                                </div>


                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-lg btn-primary pull-left">Add</button>
                                </div>
                    
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- /Add vehicle Modal -->  

                    {{--{{ $rides->links() }} --}}

                </div>
            </div>
        </div>
    </div>

    @endsection


