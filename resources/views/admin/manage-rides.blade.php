@extends('layouts.auth')

@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')

    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <span class="text-dark">Manage Rides</span>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box ">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Rides</h3>
                        <a class="btn btn-primary mb-3" onclick="$('#addride').modal('show')">Add Ride</a>
                        <div class="table-responsive ">
                            <table class="table text-wrap table-striped table-bordered data-table">
                                <thead>
                                    <tr class="fw-bold">
                                        <th class="border-top-0 ">ID</th>
                                        <th class="border-top-0 ">Driver</th>
                                        <th class="border-top-0 ">Departure</th>
                                        <th class="border-top-0 ">Destination</th>
                                        <th class="border-top-0 ">Pickup Location</th>
                                        <th class="border-top-0 ">Type</th>
                                        <th class="border-top-0 ">Cost</th>
                                        <th class="border-top-0 ">Start Time/Day</th>
                                        <th class="border-top-0 ">Num of Seats</th>
                                        <th class="border-top-0 ">Status</th>
                                        <th class="border-top-0 ">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rides as $ride)

                                        <!-- Edit ride Modal -->

                                        <div id="updateride{{ $ride->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title ">Update Ride</strong></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form style="padding:2px;" role="form" method="post"
                                                            action="{{ route('updateride', $ride->id) }}" class="row g-3">
                                                            @csrf

                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="departure" class="form-label">Departure
                                                                        Town</label>
                                                                    <input type="text" class="form-control"
                                                                        id="departure" name="departure"
                                                                        value="{{ $ride->departure }}" placeholder="from.."
                                                                        required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="destination" class="form-label">Arrival
                                                                        Town</label>
                                                                    <input type="text" class="form-control"
                                                                        id="destination" name="destination"
                                                                        value="{{ $ride->destination }}" placeholder="to.."
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="day" class="form-label">Day</label>
                                                                    <input type="text" class="form-control"
                                                                        name="start_day" id="start_day" placeholder="day.."
                                                                        required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="time" class="form-label">Time</label>
                                                                    <input type="text" class="form-control"
                                                                        name="start_time" id="start_time"
                                                                        placeholder="time.." required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-7">
                                                                    <label for="type" class="form-label">For</label>
                                                                    <select name="type" id="type"
                                                                        class="form-select"
                                                                        placeholder="Transport Persons or Goods">
                                                                        <option value="persons"
                                                                            <?= $ride->type == 'persons' ? 'selected' : '' ?>>
                                                                            persons</option>
                                                                        <option value="goods"
                                                                            <?= $ride->type == 'goods' ? 'selected' : '' ?>>
                                                                            goods</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="cost" class="form-label">Cost</label>
                                                                    <input type="text" class="form-control"
                                                                        id="cost" placeholder="we advice"
                                                                        name="cost" value="{{ $ride->cost }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label for="noOfseats" class="form-label">No of
                                                                        Seats</label>
                                                                    <input type="number" class="form-control"
                                                                        id="noOfseats" name="noOfSeats"
                                                                        value="{{ $ride->num_of_seats }}" required>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label for="pickup_location" class="form-label">Pickup
                                                                        Location</label>
                                                                    <input type="text" class="form-control"
                                                                        name="pickup_location" id="pickup_location"
                                                                        value="{{ $ride->pickup_location }}"
                                                                        placeholder="agreed meeting position" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="vehicle" class="form-label">Vehicle</label>
                                                                <input type="text" class="form-control" name="vehicle"
                                                                    placeholder="describe your vehicle"
                                                                    value="{{ $ride->vehicle }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="comments" class="form-label">Comments</label>
                                                                <textarea type="text" class="form-control" name="comments" id="comments"
                                                                    placeholder="describe the exciting features of your vehicle so the client is attract to your offer">
                                                                        
                                                                        </textarea>
                                                            </div>
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">

                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary">Update
                                                                    Ride</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /Edit ride Modal -->

                                        <!--Delete ride Modal -->

                                        <div class="modal fade" id="deleteride{{ $ride->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Ride</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete {{ $ride->driver->username }}'s
                                                            ride?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="submit-form"
                                                            action="{{ route('deleteride', $ride->id) }}" method="POST"
                                                            class="hidden">
                                                            @csrf
                                                            @method('POST')
                                                        </form>
                                                        <a href="{{ route('deleteride', $ride->id) }}" type="button"
                                                            class="btn btn-danger "
                                                            onclick="event.preventDefault(); document.getElementById('submit-form').submit();">Yes,
                                                            i'm sure</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add ride Modal -->
        <div id="addride" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">Add Ride</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form style="padding:2px;" role="form" method="post" action="{{ route('add-ride') }}"
                            class="row g-3">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="departure" class="form-label">Departure Town</label>
                                    <input type="text" class="form-control" id="departure" name="departure"
                                        placeholder="from.." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="destination" class="form-label">Arrival Town</label>
                                    <input type="text" class="form-control" id="destination" name="destination"
                                        placeholder="to.." required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="day" class="form-label">Day</label>
                                    <input type="text" class="form-control" name="start_day" id="start_day"
                                        placeholder="day.." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="time" class="form-label">Time</label>
                                    <input type="text" class="form-control" name="start_time" id="start_time"
                                        placeholder="time.." required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <label for="type" class="form-label">For</label>
                                    <select name="type" id="type" class="form-select"
                                        placeholder="Transport Persons or Goods">
                                        <option value="persons" selected>persons</option>
                                        <option value="goods">goods</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="text" class="form-control" id="cost" placeholder="we advice"
                                        name="cost" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="noOfseats" class="form-label">No of Seats</label>
                                    <input type="number" class="form-control" id="noOfseats" name="noOfSeats" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="pickup_location" class="form-label">Pickup Location</label>
                                    <input type="text" class="form-control" name="pickup_location"
                                        id="pickup_location" placeholder="agreed meeting position" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="vehicle" class="form-label">Vehicle</label>
                                <input type="text" class="form-control" name="vehicle"
                                    placeholder="describe your vehicle" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea type="text" class="form-control" name="comments" id="comments"
                                    placeholder="describe the exciting features of your vehicle so the client is attract to your offer">
                                      
                                      </textarea>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add ride Modal -->


        <!-- ============================================================== -->

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
                ajax: "{{ route('mrides') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'driver',
                        name: 'driver'
                    },
                    {
                        data: 'departure',
                        name: 'departure'
                    },
                    {
                        data: 'destination',
                        name: 'destination'
                    },
                    {
                        data: 'pickup_location',
                        name: 'pickup_location'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'cost',
                        name: 'cost'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'num_of_seats',
                        name: 'num_of_seats'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
