
<div class="col-sm-2">
	<ul class="gm-list hidden-xs">
		<li class="nav-header">@lang('page.accnt')</li>

		<li class="@yield('sub-menu')">
			<a  href="{{ route('user.dashboard') }}">
				<i class="fa fa-inbox"></i> @lang('page.user_dashboard')
			</a>  
		</li>

		<li class="@yield('sub-menu1')">

			<a  href="{{ route('my-profile') }}">
				<i class="fa fa-inbox"></i> @lang('page.profile')
			</a>  
		</li>

		<li class="@yield('sub-menu2')">

			<a  href="{{ route('my-journeys') }}">

				<i class="fa fa-folder-open"></i> @lang('page.my_journey')
			</a>  
		</li>

		<li class="@yield('sub-menu3')">

			<a  href="{{ route('my-rides') }}">

				<i class="fa fa-folder-open"></i> @lang('page.my_lift')
			</a>  
		</li>

		<li class="@yield('sub-menu4')">
			<a  href="{{ route('my-vehicles') }}">
				<i class="fa fa-folder-open"></i> My Vehicles
			</a>  
		</li>

		<!--@if(\Auth::user()->type == 'administrator')
		<li class="">
			<a href="/admin/translations">
				<i class="fa fa-folder-open"></i> @lang('page.acount_sidebar.translate')
			</a>  
		</li>
		@endif

		 <li class="">
			<a href="">
				<i class="fa fa-folder-open"></i> 
			</a>  
		</li> -->
	</ul>
</div>
