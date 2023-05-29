@extends('layouts.app')

@section('title', 'My Profile')

@section('active')

@section('sub-menu1', 'active')

@section('content')

    @include('parts.small_header_extend')

    <style type="text/css">
        span,
        label {
            font-size: 18px;
        }

        .badge {
            background: #f7972a;
        }

        .col-sm-10 {
            padding-bottom: 20px;
        }

        .inner_column {
            float: left;
            width: 50%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .inner_row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>

    <div class="main ">
        <div class="container">
            <div class="row">

                @include('parts.account_sidebar')

                <div class="col-sm-10">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif


                    @if ($message = Session::get('error'))
                        <div class="alert alert-error alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <h1>Welcome {{ $user->username }}</h1>

                    <hr class="hidden-xs">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="white-box">
                                <div class="d-md-flex mb-3">
                                    <h3 class="box-title mb-3">Recent Ride</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">Ride</th>
                                                <th class="border-top-0">Day/Time</th>
                                                <th class="border-top-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td class="txt-oflo">Elite admin</td>
                                                <td>SALE</td>
                                                
                                                <td><span class="text-success">$24</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td class="txt-oflo">Real Homes WP Theme</td>
                                                <td>EXTENDED</td>
                                                
                                                <td><span class="text-info">$1250</span></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td class="txt-oflo">Ample Admin</td>
                                                <td>EXTENDED</td>
                                                
                                                <td><span class="text-info">$1250</span></td>
                                            </tr>
                                           
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="white-box">
                                <div class="d-md-flex mb-3">
                                    <h3 class="box-title mb-3">Recent Trips</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">Journey</th>
                                                <th class="border-top-0">Day/Time</th>
                                                
                                                <th class="border-top-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td class="txt-oflo">Elite admin</td>
                                                <td>SALE</td>
                                                
                                                <td><span class="text-success">$24</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td class="txt-oflo">Real Homes WP Theme</td>
                                                <td>EXTENDED</td>
                                                
                                                <td><span class="text-info">$1250</span></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td class="txt-oflo">Ample Admin</td>
                                                <td>EXTENDED</td>
                                                
                                                <td><span class="text-info">$1250</span></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                    </div>


                    {{--<div class="inner_row">
                        <div class="inner_column">
                            <div class="col-md-3">
                                @if (Auth::user()->avatar == null)
                                    <img src="/assets/images/default-avatar.png" width="100%" height="100%"
                                        style="border-radius:15px;">
                                @else
                                    <img src="{{ '/uploads/avatars/' . Auth::user()->avatar }}" width="300px"
                                        height="300px" style="border-radius:15px;">
                                @endif
                            </div>
                        </div>

                    </div>--}}

                </div>
            </div>
        </div>


    @endsection

    @section('foot')

        <script type="text/javascript">
            function changePassword() {
                console.log('changing password');
                $("#reset-password-modal").modal();
            }
        </script>

    @endsection
