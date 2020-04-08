@extends('layouts.app', ['title' => __('Shift Management')])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Shifts') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('shift.create') }}" class="btn btn-sm btn-primary">{{ __('Add Shift') }}</a>
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
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Shift Span</th>
                <th scope="col">{{ __('Shift Name') }}</th>
                <th scope="col">{{ __('Description') }}</th>
                <th scope="col">{{ __('Start Time') }}</th>
                <th scope="col">{{ __('Late After') }}</th>
                <th scope="col">{{ __('Shift End') }}</th>
                <th scope="col">{{ __('Early-go Allowed') }}</th>
                <th scope="col">{{ __('Overtime-start') }}</th>
                <th scrop="col">Lunch Duration</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($shifts as $shift)

              @if($loop->iteration%2 == 0)
              <tr style="background-color:lightgreen !important;">
              @else
              <tr style="background-color:#9fbfdf !important;">
              @endif
                <td>@if($shift->sunday_check == 0) Mon-Sun @elseif($shift->sunday_check == 1) Mon-Sat + Sun(Overtime) @else Mon-Sat @endif</td>
                <td @if($shift->sunday_check == 2) rowspan="2" @endif>{{ $shift->name }}</td>
                <td @if($shift->sunday_check == 2) rowspan="2" @endif>{{ $shift->description }}</td>
                <td>{{ $shift->start_time }}</td>
                <td>{{ \Carbon\Carbon::parse($shift->start_time)->addHours($shift->late_time)->addMinutes(60*($shift->late_time - floor($shift->late_time)))->toTimeString() }}</td>
                <td>{{ \Carbon\Carbon::parse($shift->start_time)->addHours($shift->shift_duration)->addMinutes(60*($shift->shift_duration - floor($shift->shift_duration)))->toTimeString() }}</td>
                <td>{{ \Carbon\Carbon::parse($shift->start_time)->addHours($shift->shift_duration)->addMinutes(60*($shift->shift_duration - floor($shift->shift_duration)))->subHours($shift->early_go_time)->subMinutes(60*($shift->early_go_time - floor($shift->early_go_time)))->toTimeString() }}</td>
                <td>{{\Carbon\Carbon::parse($shift->start_time)->addHours($shift->shift_duration)->addMinutes(60*($shift->shift_duration - floor($shift->shift_duration)))->addHours($shift->overtime_start_time)->addMinutes(60*($shift->overtime_start_time-floor($shift->overtime_start_time)))->toTimeString() }}</td>
                <td>{{ \App\Http\Controllers\HelperController::floatToTime($shift->lunch_duration) }}</td>
                <td class="text-right" @if($shift->sunday_check == 2) rowspan="2" @endif >
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                      <form action="{{ route('shift.destroy', $shift) }}" method="post">
                        @csrf
                        @method('delete')

                        <a class="dropdown-item" href="{{ route('shift.edit', $shift) }}">{{ __('Edit') }}</a>
                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this shift?") }}') ? this.parentElement.submit() : ''">
                          {{ __('Delete') }}
                        </button>
                      </form>

                    </div>
                  </div>
                </td>
              </tr>
              @if($shift->sunday_check == 2)
              @if($loop->iteration%2 == 0)
              <tr style="background-color:lightgreen !important;">
              @else
              <tr style="background-color:#9fbfdf !important;">
              @endif
                <td>Sunday</td>

                <td>{{ $shift->sunday_start_time }}</td>
                <td>{{ \Carbon\Carbon::parse($shift->sunday_start_time)->addHours($shift->sunday_late_time)->addMinutes(60*($shift->sunday_late_time - floor($shift->sunday_late_time)))->toTimeString() }}</td>
                <td>{{ \Carbon\Carbon::parse($shift->sunday_start_time)->addHours($shift->sunday_shift_duration)->addMinutes(60*($shift->sunday_shift_duration - floor($shift->sunday_shift_duration)))->toTimeString() }}</td>
                <td>{{ \Carbon\Carbon::parse($shift->sunday_start_time)->addHours($shift->sunday_shift_duration)->addMinutes(60*($shift->sunday_shift_duration - floor($shift->sunday_shift_duration)))->subHours($shift->sunday_early_go_time)->subMinutes(60*($shift->sunday_early_go_time - floor($shift->sunday_early_go_time)))->toTimeString() }}</td>
                <td>{{\Carbon\Carbon::parse($shift->sunday_start_time)->addHours($shift->sunday_shift_duration)->addMinutes(60*($shift->sunday_shift_duration - floor($shift->sunday_shift_duration)))->addHours($shift->sunday_overtime_start_time)->addMinutes(60*($shift->sunday_overtime_start_time-floor($shift->sunday_overtime_start_time)))->toTimeString() }}</td>
                <td>{{ \App\Http\Controllers\HelperController::floatToTime($shift->sunday_lunch_duration) }}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4">
          <nav class="d-flex justify-content-end" aria-label="...">
            {{ $shifts->links() }}
          </nav>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection
