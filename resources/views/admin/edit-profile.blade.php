@extends('layouts.auth')

@section('content')

@include('admin.topmenu')
@include('admin.sidebar')


    <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <p class="">Profile page</p>
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

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

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
                <!-- Row -->
                <div class="row justify-content-center">
                    <!-- Column -->
                    <div class=" col col-lg-8 justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                <!--<h1 class="card-title">Edit Profile</h1> -->
                                <form id="update_form" class="form-horizontal form-material" action="{{route('update-p')}}" method="POST">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">Username</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input id="username" type="text" placeholder="{{$user->username}}" name="username"
                                                class="form-control p-0 border-0 @error('username') is-invalid @enderror"> 
                                                @error('username')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0">First Name</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="{{$user->first_name}}"
                                                class="form-control p-0 border-0"> </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="example-email" class="col-md-12 p-0">Last Name</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder="{{$user->last_name}}"
                                                class="form-control p-0 border-0" name="lastName"
                                                id="example-email">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="email" class="col-md-12 p-0">Email</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input id="email" type="text" class="form-control p-0 border-0 @error('email') is-invalid @enderror" name="email" placeholder="{{$user->email}}">
                                            @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="phone" class="col-md-12 p-0">Phone Number</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input id="phone" type="number" placeholder="{{$user->phone_number}}"
                                                class="form-control p-0 border-0 @error('phone') is-invalid @enderror" name="phone">
                                                @error('phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div class="col-sm-12">
                                            <input class="btn btn-success" type="submit" id="update" value="Update Profile" name="update">
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

$('#update_form').on("submit", function(event){  

  event.preventDefault();
  
  $.ajax({
  type: "POST",
  url: "{{ route('update-p') }}",
  data: $('#update_form').serialize(),

  beforeSend:function(){  

     $('#update').val("Updating");  
    },
    success:function(data){ 

        $('#update').val("Update");      
    } 
    });
});


</script>

@endsection
