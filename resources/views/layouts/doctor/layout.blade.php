@include('layouts.admin.header')
<body id="page-top">

@php
$websiteLang=App\ManageText::all();
@endphp
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Route::is('doctor.dashboard')?'active':'' }}">
                <a class="nav-link" href="{{ route('doctor.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ $websiteLang->where('lang_key','dashboard')->first()->custom_lang }}</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Charts -->
            <li class="nav-item {{ Route::is('doctor.today.appointment') || Route::is('doctor.treatment') ?'active':'' }}">
                <a class="nav-link" href="{{ route('doctor.today.appointment') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ $websiteLang->where('lang_key','today_app')->first()->custom_lang }}</span></a>
            </li>
             <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{ $websiteLang->where('lang_key','manage_app')->first()->custom_lang }}</span>
                </a>
                <div id="collapsePages" class="collapse {{ Route::is('doctor.new.appointment') || Route::is('doctor.all.appointment') || Route::is('doctor.already.treatment') ?'show':'' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Route::is('doctor.new.appointment')?'active':'' }}" href="{{ route('doctor.new.appointment') }}">{{ $websiteLang->where('lang_key','new_app')->first()->custom_lang }}</a>
                        <a class="collapse-item {{ Route::is('doctor.all.appointment') || Route::is('doctor.already.treatment') ?'active':'' }}" href="{{ route('doctor.all.appointment') }}">{{ $websiteLang->where('lang_key','app_history')->first()->custom_lang }}</a>


                    </div>
                </div>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#live-consultant"
                    aria-expanded="true" aria-controls="live-consultant">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>{{ $websiteLang->where('lang_key','live_consult')->first()->custom_lang }}</span>
                </a>
                <div id="live-consultant" class="collapse {{
                    Route::is('doctor.zoom-credential') || Route::is('doctor.zoom-meetings') || Route::is('doctor.create-zoom-meeting') || Route::is('doctor.edit-zoom-meeting') || Route::is('doctor.meeting-history') || Route::is('doctor.upcomming-meeting') ? 'show':'' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Route::is('doctor.zoom-meetings') || Route::is('doctor.create-zoom-meeting') || Route::is('doctor.edit-zoom-meeting')?'active':'' }}" href="{{ route('doctor.zoom-meetings') }}">{{ $websiteLang->where('lang_key','meeting')->first()->custom_lang }}</a>

                        <a class="collapse-item {{ Route::is('doctor.upcomming-meeting') ?'active':'' }}" href="{{ route('doctor.upcomming-meeting') }}">{{ $websiteLang->where('lang_key','upcoming_meeting')->first()->custom_lang }}</a>
                        <a class="collapse-item {{ Route::is('doctor.meeting-history') ?'active':'' }}" href="{{ route('doctor.meeting-history') }}">{{ $websiteLang->where('lang_key','meeting_history')->first()->custom_lang }}</a>


                        <a class="collapse-item {{ Route::is('doctor.zoom-credential')?'active':'' }}" href="{{ route('doctor.zoom-credential') }}">{{ $websiteLang->where('lang_key','setting')->first()->custom_lang }}</a>


                    </div>
                </div>
            </li>

             <!-- Nav Item - Charts -->
            <li class="nav-item {{ Route::is('doctor.leave.index')?'active':'' }}">
                <a class="nav-link" href="{{ route('doctor.leave.index') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ $websiteLang->where('lang_key','manage_leave')->first()->custom_lang }}</span></a>
            </li>

             <!-- Nav Item - Charts -->
            <li class="nav-item {{ Route::is('doctor.payment.history')?'active':'' }}">
                <a class="nav-link" href="{{ route('doctor.payment.history') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ $websiteLang->where('lang_key','payment_history')->first()->custom_lang }}</span></a>
            </li>
             <!-- Nav Item - Charts -->
            <li class="nav-item {{ Route::is('doctor.schedule')?'active':'' }}">
                <a class="nav-link" href="{{ route('doctor.schedule') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ $websiteLang->where('lang_key','my_schedule')->first()->custom_lang }}</span></a>
            </li>

             <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.message.index') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ $websiteLang->where('lang_key','msg')->first()->custom_lang }}</span></a>
            </li>




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 customToggle" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @php
                                    $doctorInfo=Auth::guard('doctor')->user();
                                @endphp
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucfirst($doctorInfo->name) }}</span>
                                @if ($doctorInfo->image)
                                    <img class="img-profile rounded-circle"
                                    src="{{ url($doctorInfo->image) }}">
                                @else
                                    <img class="img-profile rounded-circle"
                                    src="{{ url('default-user.jpg') }}">
                                @endif

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('doctor.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ $websiteLang->where('lang_key','profile')->first()->custom_lang }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('doctor.logout') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ $websiteLang->where('lang_key','logout')->first()->custom_lang }}
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                   @yield('doctor-content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


@include('layouts.admin.footer')
