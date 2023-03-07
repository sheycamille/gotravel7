@extends('layouts.auth')

@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')

    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <span class="text-dark">Manage Drivers</span>
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
                        <h3 class="card-title mb-3">Drivers</h3>
                        <!-- <a  class="btn btn-primary mb-3" onclick="$('#addride').modal('show')">Add Ride</a> -->
                        <div class="table-responsive ">
                            <table class="table text-wrap table-striped table-bordered data-table ">
                                <thead>
                                    <tr class="fw-bold">
                                        <th class="border-top-0 ">ID</th>
                                        <th class="border-top-0 ">Username</th>
                                        <th class="border-top-0 ">Email</th>
                                        <th class="border-top-0 ">Phone No</th>
                                        <th class="border-top-0 ">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--@foreach ($drvers as $drver)
    <tr>
                                                        <td>{{ $drver->id }}</td>
                                                        <td>{{ $drver->username }}</td>
                                                        <td>{{ $drver->email }}</td>
                                                        <td>{{ $drver->phone_number }}</td>
                                                        <td></td>
                                                    </tr>
    @endforeach-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                ajax: "{{ route('get-drivers') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
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
