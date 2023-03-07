@extends('layouts.auth')

@section('content')

@include('admin.topmenu')
@include('admin.sidebar')

      <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <span class="text-dark">Manage Users</span>
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
                        <div class="white-box">
                            <h3 class="box-title">Manage Users</h3>
                            <div class="table-responsive ">
                                <table class="table text-nowrap table-striped table-bordered yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0 fw-bold">ID</th>
                                            <th class="border-top-0 fw-bold">Full Name</th>
                                            <th class="border-top-0 fw-bold">email</th>
                                            <th class="border-top-0 fw-bold">Phone Number</th>
                                            <th class="border-top-0 fw-bold">Role</th>
                                            <th class="border-top-0 fw-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->phone_number}}</td>
                                            <td>{{$user->type}}</td>  
                                            <td>
                                                @if($user->status == '1')
                                                <a href="{{ route('unblockuser', $user->id) }}" class=" btn rounded btn-primary ms-3 btn-sm">Unblock</a>
                                                @else
                                                <a href="{{ route('blockuser', $user->id) }}" class=" btn rounded btn-danger ms-3 btn-sm">Block</a>
                                                @endif
    
                                                <a  class=" btn rounded btn-secondary ms-3 btn-sm"  onclick="$('#edituser-{{$user->id}}').modal('show')">Edit</a>
                                                
                                            </td>  
                                        </tr>

                                        
                                        <!-- Edit user Modal -->
                                        <div id="edituser-{{$user->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <h4 class="modal-title ">Edit User</strong></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form style="padding:3px;" role="form" method="post"
                                                            action="{{route('updateuser', $user->id)}}">
                                                            <h5 class=" ">Firstname</h5>
                                                            <input style="padding:5px;" class="form-control "
                                                                value="{{$user->first_name}}" type="text" name="fname"
                                                                required><br />
                                                            <h5 class=" ">Lastname</h5>
                                                            <input style="padding:5px;" class="form-control "
                                                                value="{{$user->last_name}}" type="text" name="l_name"
                                                                required><br />
                                                            <h5 class=" ">Email</h5>
                                                            <input style="padding:5px;" class="form-control "
                                                                value="{{$user->email}}" type="email" name="email"
                                                                required><br />
                                                            <h5 class=" ">Phone Number</h5>
                                                            <input style="padding:5px;" class="form-control "
                                                                value="{{$user->phone_number}}" type="text" name="phone"
                                                                required>
                                                            <br>
                                                            <h5 class=" ">Role</h5>
                                                            <select class="form-control " name="role">
                                                                <option value="driver" <?= $user->type == 'driver' ? 'selected' : '' ?>>driver</option>
                                                                <option value="passenger" <?= $user->type == 'passenger' ? 'selected' : '' ?>>passenger</option>
                                    
                                                            </select>
                                                            <br>
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                        <!-- <input type="hidden" name="user_id" value="{{$user->id}}">-->
                                                            <input type="submit" class="btn btn-info"
                                                                value="Update account">
                                                        </form>
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
    $(function () {
      
      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('fetchusers') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'names', name: 'names'},
              {data: 'email', name: 'email'},
              {data: 'phone_number', name: 'phone'},
              {data: 'type', name: 'type'},
              {
                  data: 'action', 
                  name: 'action', 
                  orderable: true, 
                  searchable: true
              },
          ]
      });
      
    });
  </script>


@endsection


