@extends('layouts.app', ['title' => __('Leaves Management')])

@section('content')
@include('leaves.employee.partials.header', ['title' => __('Add Employee Leave')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Employee Leave Management') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('leaves.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('leaves.store') }}" autocomplete="off">
            @csrf

            <h6 class="heading-small text-muted mb-4">{{ __('Leave information') }}</h6>
            <div class="pl-lg-4">
              <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-start_date">{{ __('Start Date') }}</label>
                <input type="date" name="start_date" id="input-start_date" class="form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}" value="{{ old('start_date') }}" required autofocus>

                @if ($errors->has('start_date'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('start_date') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-end_date">{{ __('End Date') }}</label>
                <input type="date" name="end_date" id="input-end_date" class="form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}" value="{{ old('end_date') }}" required >

                @if ($errors->has('end_date'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('end_date') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('employee_id') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-employee_id">{{ __('Select Employee') }}</label>
                <select name="emp_id" id="input-emp_id" class="form-control form-control-alternative{{ $errors->has('employee_id') ? 'is-invalid' : '' }}">
                  @foreach($employees as $employee)

                  <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                  @endforeach
                </select>

                @if ($errors->has('employee_id'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('employee_id') }}</strong>
                </span>
                @endif
              </div>
              <input name="user_id" type="hidden" value="{{ Auth::id() }}" />

              <div class="form-group{{ $errors->has('subject') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-subject">{{ __('Subject') }}</label>
                <input type="text" name="subject" id="input-subject" class="form-control form-control-alternative{{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="{{ __('Subject') }}" value="{{ old('subject') }}" required >

                @if ($errors->has('subject'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('subject') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>

                @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-status">{{ __('Type') }}</label>
                <select name="type" id="input-type" class="form-control form-control-alternative{{ $errors->has('type') ? 'is-invalid' : '' }}">

                  <option value="Casual">Casual</option>
                  <option value="Annual">Annual</option>

                </select>

                @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
                @endif
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
