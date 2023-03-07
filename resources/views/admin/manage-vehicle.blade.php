    @extends('layouts.auth')

    @section('content')
        @include('admin.topmenu')
        @include('admin.sidebar')

        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <span class="text-dark">Manage Vehicles</span>
                </div>

            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">×</button>
                </div>
            @endif


            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="white-box ">
                        <div class="card-body">
                            <h3 class="card-title mb-3">Vehicles</h3>
                            <a class="btn btn-primary mb-3" onclick="$('#addvehicle').modal('show')">Add vehicle</a>
                            <div class="table-responsive ">
                                <table class="table text-nowrap table-striped table-bordered data-table ">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0 ">ID</th>
                                            <th class="border-top-0 ">Owner</th>
                                            <th class="border-top-0 ">Plate Number</th>
                                            <th class="border-top-0 ">Type</th>
                                            <th class="border-top-0 ">Num of Seats</th>
                                            <th class="border-top-0 ">Cost per Seat</th>
                                            <th class="border-top-0 ">Color</th>
                                            <th class="border-top-0 ">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vehicles as $vehicle)
                                            <!-- Edit vehicle Modal -->
                                            <div id="updatevehicle{{ $vehicle->id }}" class="modal fade" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title ">Edit Vehicle</strong></h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form style="padding:2px;" role="form" method="post"
                                                                action="{{ route('update-v', $vehicle->id) }}"
                                                                class="row g-3">
                                                                @csrf

                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="plate_no" class="form-label">Plate
                                                                            Number</label>
                                                                        <input type="text" class="form-control"
                                                                            id="plate_no"
                                                                            value="{{ $vehicle->plate_number }}"
                                                                            name="plate_no" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="no_seats" class="form-label">No of
                                                                            Seats</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $vehicle->num_of_seats }}"
                                                                            id="no_seats" name="no_seats" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="cost_seat" class="form-label">Cost Per
                                                                            Seat</label>
                                                                        <input type="text" class="form-control"
                                                                            name="cost_seat" id="cost_seat"
                                                                            value="{{ $vehicle->cost_per_seat }}" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="color"
                                                                            class="form-label">Color</label>
                                                                        <input type="text" class="form-control"
                                                                            name="color" id="color"
                                                                            value="{{ $vehicle->color }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-7">
                                                                        <label for="brand"
                                                                            class="form-label">Brand</label>
                                                                        <input type="text" class="form-control"
                                                                            id="brand" value="{{ $vehicle->brand }}"
                                                                            name="brand" required>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label for="type"
                                                                            class="form-label">Type</label>
                                                                        <select name="type" id="type"
                                                                            class="form-select"
                                                                            placeholder="Transport Persons or Goods">
                                                                            @foreach ($cartype as $car)
                                                                                <option
                                                                                    <?= $car == $vehicle->type ? 'selected' : '' ?>>
                                                                                    {{ $car }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="descriptn"
                                                                        class="form-label">Description</label>
                                                                    <textarea type="text" class="form-control  " name="descriptn" value="{{ $vehicle->description }}"
                                                                        id="descriptn" required>
                                                                        
                                                                        </textarea>
                                                                </div>
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">

                                                                <div class="col-12">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Edit vehicle Modal -->

                                            <!--Delete vehicle Modal -->
                                            <div class="modal fade" id="deletevehicle{{ $vehicle->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Vehicle
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this vehicle?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form id="submit-form"
                                                                action="{{ route('delete-v', $vehicle->id) }}"
                                                                method="POST" class="hidden">
                                                                @csrf
                                                                @method('POST')
                                                            </form>
                                                            <a href="{{ route('delete-v', $vehicle->id) }}"
                                                                type="button" class="btn btn-danger "
                                                                onclick="event.preventDefault(); document.getElementById('submit-form').submit();">Yes,
                                                                i'm sure</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- delete vehicle modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add vehicle Modal -->
            <div id="addvehicle" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title ">Add Vehicle</strong></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form style="padding:2px;" role="form" method="post" action="{{ route('store-v') }}"
                                class="row g-3">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="plate_no" class="form-label">Plate Number</label>
                                        <input type="text" class="form-control" id="plate_no" name="plate_no"
                                            placeholder="enter number plate" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_seats" class="form-label">No of Seats</label>
                                        <input type="text" class="form-control" id="no_seats" name="no_seats"
                                            placeholder="enter number of seats" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="cost_seat" class="form-label">Cost Per Seat</label>
                                        <input type="text" class="form-control" name="cost_seat" id="cost_seat"
                                            placeholder="enter cost per seat" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="color" class="form-label">Color</label>
                                        <input type="text" class="form-control" name="color" id="color"
                                            placeholder="vehicle color" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-7">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" class="form-control" id="brand"
                                            placeholder="vehicle brand " name="brand" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="type" class="form-label">Type</label>
                                        <select name="type" id="type" class="form-select"
                                            placeholder="Transport Persons or Goods">
                                            @foreach ($cartype as $car)
                                                <option value="{{ $car }}">{{ $car }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="descriptn" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" name="descriptn" id="descriptn"
                                        placeholder="describe the exciting features of your vehicle" required>
                                            
                                            </textarea>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add vehicle Modal -->

            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
    @endsection

    @section('javascript')
        <script type="text/javascript">
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('fetchvehicles') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'owner',
                            name: 'owner'
                        },
                        {
                            data: 'plate_number',
                            name: 'plate_number'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'num_of_seats',
                            name: 'num_of_seats'
                        },
                        {
                            data: 'cost_per_seat',
                            name: 'cost_per_seat'
                        },
                        {
                            data: 'color',
                            name: 'color'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: true
                        },
                    ]
                });

            });
        </script>
    @endsection
