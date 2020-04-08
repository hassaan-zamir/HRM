

@extends('layouts.app', ['title' => __('Employee Monthly Attendance Report')])


@section('head-content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
@endsection
@section('content')



<!-- cards -->

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid">
    <div class="header-body">
      <!-- Card stats -->
      @if(true)
      <div class="row">
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Employee Information</h5><br>
                  <span class="h4 font-weight-bold mb-0">ID : </span> {{ $employee['id'] }} <br>
                  <span class="h4 font-weight-bold mb-0">Name : </span> {{ $employee['full_name'] }}<br>
                  <span class="h4 font-weight-bold mb-0">Department : </span>{{ $employee['department'] }}<br>
                  <span class="h4 font-weight-bold mb-0">Designation : </span>{{ $employee['designation'] }}
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                    <i class="fas fa-id-card"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-success mr-2"><i class="fa fa-calendar" aria-hidden="true"></i> {{ (explode(' ',\Carbon\Carbon::parse($employee['join_date'])->toDateTimeString()))[0] }}</span>
                <span class="text-nowrap">Joined</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Work Summary</h5><br>
                  <span class="h4 font-weight-bold mb-0">Working Days : </span>{{ $workSummary['work_days'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Worked Days : </span>{{ $workSummary['worked_days'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Working Hours : </span>{{ $workSummary['working_hours'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Worked Hours : </span>{{ \App\Http\Controllers\HelperController::secondsToClock($workSummary['worked_hours']) }}<br/>
                  <span class="h4 font-weight-bold mb-0">Short Duty Hours : </span>{{ $workSummary['short_duty_hours'] }}<br/>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                    <i class="fas fa-people-carry"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-muted text-sm">
                <!-- <span class="text-danger mr-2">
                  <i class="fas fa-arrow-down"></i> 3.48%
                </span>
                <span class="text-nowrap"> This Month</span> -->
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Late/Early Summary</h5><br>
                  <span class="h4 font-weight-bold mb-0">Late Days : {{ $leSummary['late_days'] }}</span><br/>
                  <span class="h4 font-weight-bold mb-0">Early Days : {{ $leSummary['early_days'] }}</span><br/>
                  <span class="h4 font-weight-bold mb-0">Late/Early Days : {{ $leSummary['late_days']+$leSummary['early_days'] }}</span><br/>
                  <span class="h4 font-weight-bold mb-0">Late Hours : {{ \App\Http\Controllers\HelperController::secondsToClock($leSummary['late_hours']) }}</span><br/>
                  <span class="h4 font-weight-bold mb-0">Early Hours : {{ \App\Http\Controllers\HelperController::secondsToClock($leSummary['early_hours']) }}</span><br/>
                  <span class="h4 font-weight-bold mb-0">Late/Early Hours : {{ \App\Http\Controllers\HelperController::secondsToClock($leSummary['late_hours']+$leSummary['early_hours']) }}</span><br/>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-muted text-sm">
                <!-- <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                <span class="text-nowrap">Since yesterday</span> -->
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Extras</h5><br/>
                  <span class="h4 font-weight-bold mb-0">Casual Leave : </span>{{ $leavesSummary['casual_leaves'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Annual Leave : </span>{{ $leavesSummary['annual_leaves'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Absent : </span>{{ $extraSummary['absent'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Sun/Holiday : </span>{{ $extraSummary['holiday'] }}<br/>
                  <span class="h4 font-weight-bold mb-0">Overtime : </span>{{ \App\Http\Controllers\HelperController::secondsToClock($extraSummary['overtime']) }}<br/>
                  <span class="h4 font-weight-bolb mb-0">Late Penalty : </span>{{ floor($leSummary['late_days']/3) }}<br/>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                    <i class="fas fa-plus-circle"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-muted text-sm">
                <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                <span class="text-nowrap">Since last month</span> -->
              </p>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<!--content -->

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Employee Monthly Attendance Report') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="#" id="printBtn" class="btn btn-sm btn-primary printHide">Print</a>
              <a href="#" class="btn btn-sm btn-primary">Go Back</a>
            </div>
          </div>
        </div>

        <div class="col-12">
          @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
        </div>

        <div class="table-responsive">
          <table class="table align-items-center table-flush" id="reportTable" class="display">
            <thead class="thead-light">
              <tr>
                <th scope="col" >#</th>
                <th scope="col">Date</th>
                <th scope="col">In-time</th>
                <th scope="col">Out-time</th>
                <th scope="col">Status</th>
                <th scope="col">Worked Hours</th>
                <th scope="col">Shift</th>
                <th scope="col">Overtime</th>
                <th scope="col">Late Hrs</th>
                <th scope="col">Early Hrs</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rows as $row)


              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['in_time'] }}</td>
                <td>{{ $row['out_time'] }}</td>
                <td >
                  @if(isset($row['holiday']))
                    <span style="color:#27ae60;" >({{ $row['holiday'] }})</span>
                  @endif

                  {!! $row['status'] !!}
                </td>
                <td>
                  {{ \App\Http\Controllers\HelperController::secondsToClock($row['worked_hours']) }}

                </td>
                <td>{{ $row['shift'] }}</td>
                <td>
                  @if(is_numeric($row['ot']))
                  {{ substr((explode(' ',\Carbon\Carbon::parse(floor($row['ot']/3600).':'.floor($row['ot']/60%60))))[1],0,-3) }}
                  @else
                  {{ $row['worked_hours'] }}
                  @endif
                </td>
                <td>
                  @if(is_numeric($row['worked_hours']))
                  {{ substr((explode(' ',\Carbon\Carbon::parse(floor($row['late_hrs']/3600).':'.floor($row['late_hrs']/60%60))))[1],0,-3) }}
                  @else
                  {{ $row['late_hrs'] }}
                  @endif
                </td>
                <td>
                  @if(is_numeric($row['worked_hours']))
                  {{ substr((explode(' ',\Carbon\Carbon::parse(floor($row['early_hrs']/3600).':'.floor($row['early_hrs']/60%60))))[1],0,-3) }}
                  @else
                  {{ $row['early_hrs'] }}
                  @endif
                </td>

              </tr>

              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4">
          <nav class="d-flex justify-content-end" aria-label="...">

          </nav>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script>
$(document).ready( function () {

    let dataTable = $('#reportTable').DataTable({
      "pageLength": 31, 
    });

    $('#printBtn').click(function(){
      dataTable.destroy();
      $('#sidenav-main').remove();
      $('#navbar-main').remove();
      $('#cardsHeader').remove();
      $('.footer').remove();
      $('#mainContainer').addClass('printTime').removeClass('container-fluid');
    });

} );
</script>
@endpush
