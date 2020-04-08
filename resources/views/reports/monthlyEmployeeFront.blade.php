@extends('layouts.app', ['title' => __('Employee Monthly Attendance Report')])

@section('head-content')
<link href="http://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
@include('reports.partials.header', ['title' => __('Reports')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Employee Monthly Attendance Report') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="/" class="btn btn-sm btn-primary">Go Back</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('reports.employee_report') }}" autocomplete="off">
            @csrf

            @if(count($errors) > 0)
            <div class="alert alert-danger" role="alert">
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <h6 class="heading-small text-muted mb-4">{{ __('Attendance Report') }}</h6>
            <div class="pl-lg-4">

              <div class="form-group" id="errors">
              </div>

              <div class="form-group">
                <label class="form-control-lable">Select Month</label>
                <input name="date" type="date" class="form-control" required value="{{ old('date') }}" />
              </div>

              <div class="form-group">
                <label class="form-control-lable">Select Employee</label>
                <select name="eid" class="form-control" required>
                  @foreach($employees as $employee)
                  <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                  @endforeach
                </select>
              </div>


            </div>


            <div class="text-center">
              <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@include('layouts.footers.auth')
</div>
@endsection
