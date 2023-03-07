@extends('layouts.auth')

@section('content')

@include('admin.topmenu')
@include('admin.sidebar')

            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row justify-content-center">
                    <!-- Column -->
                    <div class=" col col-lg-8 justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('updatepass')}}">

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

                                    @csrf 
                            
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>
                            
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('username') is-invalid @enderror" name="current_password" autocomplete="current-password">
                                            @error('current_password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                            
                                        <div class="col-md-6">
                                            <input id="new_password" type="password" class=" form-control  @error('new_password') is-invalid @enderror" name="new_password" autocomplete="current-password">
                                           <!-- <i class="far fa-eye-slash inline" id="togglePassword"></i> -->
                                            @error('new_password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>
                            
                                        <div class="col-md-6">
                                            <input id="comfirm_new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="comfirm_new_password" autocomplete="current-password">
                                            @error('comfirm_new_password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
@endsection