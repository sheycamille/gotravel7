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

                      <div class="col-sm-10">
                          @if ($message = Session::get('error'))
                              <div class="alert alert-error alert-block">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  <strong>{{ $message }}</strong>
                              </div>
                          @endif

                          <h1>Profile</h1>

                          <hr class="hidden-xs">

                          <div class="inner_row">
                              <div class="inner_column">
                                  <div class="col-md-3">
                                      @if (Auth::user()->avatar == null)
                                          <img src="/assets/images/default-avatar.png" width="100%" height="100%"
                                              style="border-radius:50%;">
                                      @else
                                          <img src="{{ '/uploads/avatars/' . Auth::user()->avatar }}" width="300px"
                                              height="300px" style="border-radius:50%;">
                                      @endif
                                  </div>
                              </div>

                              <div class="inner_column">
                                  {{-- <div class="">
            <div class="pull-right">
              <span  >Points Accumulated:</span><br>
              <label style="background-color: #4cc417;" class="badge pull-right">{{ $user->points?$user->points:0 }}</label>
            </div>
          </div> --}}
                                  <br>

                                  {{--<a onclick="changePassword()" class="btn btn-danger">Change Password</a>--}}
                                  <div class="card">
                                      <div class="card-body">
                                          <!--<h1 class="card-title">Edit Profile</h1> -->
                                          <form id="update_form" class="form-horizontal form-material"
                                              action="{{ route('update-profile') }}" method="POST">
                                              @csrf
                                              <div class="form-group mb-4">
                                                  <label class="col-md-12 p-0">Username</label>
                                                  <div class="col-md-12 border-bottom p-0">
                                                      <input id="username" type="text"
                                                          placeholder="{{ $user->username }}" name="username"
                                                          class="form-control p-0 border-0 @error('username') is-invalid @enderror">
                                                      @error('username')
                                                          <div class="alert alert-danger">{{ $message }}</div>
                                                      @enderror
                                                  </div>
                                              </div>

                                              <div class="form-group mb-4">
                                                  <label class="col-md-12 p-0">First Name</label>
                                                  <div class="col-md-12 border-bottom p-0">
                                                      <input type="text" placeholder="{{ $user->first_name }}"
                                                          class="form-control p-0 border-0">
                                                  </div>
                                              </div>
                                              <div class="form-group mb-4">
                                                  <label for="example-email" class="col-md-12 p-0">Last Name</label>
                                                  <div class="col-md-12 border-bottom p-0">
                                                      <input type="text" placeholder="{{ $user->last_name }}"
                                                          class="form-control p-0 border-0" name="lastName"
                                                          id="example-email">
                                                  </div>
                                              </div>
                                              <div class="form-group mb-4">
                                                  <label for="email" class="col-md-12 p-0">Email</label>
                                                  <div class="col-md-12 border-bottom p-0">
                                                      <input id="email" type="text"
                                                          class="form-control p-0 border-0 @error('email') is-invalid @enderror"
                                                          name="email" placeholder="{{ $user->email }}">
                                                      @error('email')
                                                          <div class="alert alert-danger">{{ $message }}</div>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="form-group mb-4">
                                                  <label for="phone" class="col-md-12 p-0">Phone Number</label>
                                                  <div class="col-md-12 border-bottom p-0">
                                                      <input id="phone" type="number"
                                                          placeholder="{{ $user->phone_number }}"
                                                          class="form-control p-0 border-0 @error('phone') is-invalid @enderror"
                                                          name="phone">
                                                      @error('phone')
                                                          <div class="alert alert-danger">{{ $message }}</div>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="form-group mb-4">
                                                  <div class="col-sm-12">
                                                      <input class="btn btn-success" type="submit" id="update"
                                                          value="Update Profile" name="update">
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                                  {{--<a style="background-color: #4cc417; border: 1px solid #4cc417"
                                      href="{{ route('edit-profile') }}" class="btn btn-warning">Edit Account
                                      Information</a>--}}
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


              <div id="reset-password-modal" tabindex="-1" role="dialog" aria-spanledby="modal-login-span"
                  aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                      <div class="modal-content col-md-10 col-md-offset-1">
                          <div class="modal-header">
                              <button type="button" data-dismiss="modal" aria-hidden="true"
                                  class="close">&times;</button>
                              <h4 id="modal-login-span" class="modal-title"><a href="#"><i
                                          class="fa fa-lock"></i></a> @lang('auth.reset_legend')</h4>
                          </div>
                          <div class="modal-body" id="reset-password_body">
                              <div class="form" style="height: inherit;">
                                  <form class="form-horizontal row" action="{{ route('reset_password') }}"
                                      method="post">
                                      {{ csrf_field() }}
                                      <input type="hidden" id='user_id' name="user_id" value="" />

                                      <div class="form-group">
                                          <span for="newpass"
                                              class="col-md-12 hide control-span">@lang('auth.old_password')</span>

                                          <div class="col-md-12">
                                              <input id="oldpass" type="password" placeholder="@lang('auth.old_password')"
                                                  class="form-control input-lg c-square" name="oldpass" required>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <span for="newpass"
                                              class="col-md-12 hide control-span">@lang('auth.new_password')</span>

                                          <div class="col-md-12">
                                              <input id="newpass" type="password" placeholder="@lang('auth.new_password')"
                                                  class="form-control input-lg c-square" name="newpass" required>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <span for="cnewpass"
                                              class="col-md-12 hide control-span">@lang('auth.confirm_password')</span>

                                          <div class="col-md-12">
                                              <input id="cnewpass" placeholder="@lang('auth.signup.confirm_password_placeholder')" type="password"
                                                  class="form-control input-lg c-square" name="cnewpass" required>
                                          </div>
                                      </div>

                                      <div class="form-group col-md-12">
                                          <input type="submit" class="btn btn-lg btn-primary pull-right"
                                              value="@lang('auth.reset_legend')" />
                                      </div>

                                  </form>
                              </div>
                          </div>
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
