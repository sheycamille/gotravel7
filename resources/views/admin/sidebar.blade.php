@section('sidebar')

    <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-decoration-none" href="{{route('dash-home')}}"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li> 
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-decoration-none" href="{{route('editprofile')}}"
                                aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-decoration-none" href="{{route('get-drivers')}}"
                                aria-expanded="false">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                <span class="hide-menu">Manage Drivers</span>
                            </a>
                            
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-decoration-none" href="{{route('get-passengers')}}"
                                aria-expanded="false">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                <span class="hide-menu">Manage Passengers</span>
                            </a>
                            
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-decoration-none" href="{{route('mrides')}}"
                                aria-expanded="false">
                                <i class="fas fa-car" aria-hidden="true"></i>
                                <span class="hide-menu">Manage Rides</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-decoration-none" href="{{route('fetchvehicles')}}"
                                aria-expanded="false">
                                <i class="fas fa-taxi" aria-hidden="true"></i>
                                <span class="hide-menu">Manage Vehicles</span>
                            </a>
                        </li>
                       <!-- <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href=""
                                aria-expanded="false">
                                <i class="fas fa-cog
                                " aria-hidden="true"></i>
                                <span class="hide-menu">Settings</span>
                            </a>
                        </li>-->
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    
@endsection