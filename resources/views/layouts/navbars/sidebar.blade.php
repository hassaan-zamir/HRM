<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fa fa-user-circle" style="color: #f4645f;"></i> {{ __('User Management') }}
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#emp_dropdown" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-address-card" style="color: #f4645f;"></i>
                        <span class="nav-link-text" >{{ __('Employee Management') }}</span>
                    </a>

                    <div class="collapse" id="emp_dropdown">
                        <ul class="nav nav-sm flex-column">
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('department.index') }}">
                                  <i class="fa fa-briefcase" style="color: #5e72e4;"></i>{{ __('Departments') }}
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('designation.index') }}">
                                  <i class="fas fa-user-tag" style="color: #5e72e4;"></i>{{ __('Designations') }}
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('employee.index') }}">
                                  <i class="fas fa-id-badge" style="color: #5e72e4;"></i>Employees
                              </a>
                          </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="#shifts_dropdown" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-clock" style="color: #f4645f;"></i>
                        <span class="nav-link-text">{{ __('Shifts Management') }}</span>
                    </a>

                    <div class="collapse " id="shifts_dropdown">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('shift.index') }}">
                                    <i class="fas fa-stopwatch" style="color: #5e72e4;"></i>{{ __('Shifts') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('roster.index') }}">
                                    <i class="fas fa-business-time" style="color: #5e72e4;"></i>{{ __('Roster') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="#attendance_dropdown" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fas fa-calendar-alt" style="color: #f4645f;"></i>
                        <span class="nav-link-text">{{ __('Attendance Management') }}</span>
                    </a>

                    <div class="collapse " id="attendance_dropdown">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('attendance.importfront') }}">
                                  <i class="fas fa-file-import" style="color: #5e72e4;"></i>{{ __('Import Attendance') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('attendance.index') }}">
                                    <i class="fas fa-tasks" style="color: #5e72e4;"></i>{{ __('Manage Attendance') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link " href="#leaves_dropdown" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-ambulance" style="color: #f4645f;"></i>
                        <span class="nav-link-text" >{{ __('Leaves Management') }}</span>
                    </a>

                    <div class="collapse " id="leaves_dropdown">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('publicHolidays.index') }}">
                                    <i class="fas fa-globe-asia" style="color: #5e72e4;"></i>{{ __('Public Holidays') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('leaves.index') }}">
                                    <i class="fas fa-procedures" style="color: #5e72e4;"></i>{{ __('Employee Leaves') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="#reports_dropdown" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-id-card" aria-hidden="true" style="color: #f4645f;"></i>
                        <span class="nav-link-text" >{{ __('Reports') }}</span>
                    </a>

                    <div class="collapse " id="reports_dropdown">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.employee_report_front') }}">
                                    All Employees Monthly Report
                                </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="{{ route('reports.multiple_in_out_front') }}">
                                Multiple In/Out Report
                              </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.time_register_front') }}">
                                    Monthly Time Register
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!--


                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-planet text-blue"></i> {{ __('Icons') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-pin-3 text-orange"></i> {{ __('Maps') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-key-25 text-info"></i> {{ __('Login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('Register') }}
                    </a>
                </li> -->

            </ul>
        </div>
    </div>
</nav>
