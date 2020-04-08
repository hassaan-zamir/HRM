@extends('layouts.app', ['title' => __('Shift Management')])

@section('content')
@include('shift.partials.header', ['title' => __('Edit Shift')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Shift Management') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('shift.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('shift.update', $shift) }}" autocomplete="off">
            @csrf
            @method('put')

            <h6 class="heading-small text-muted mb-4">{{ __('Shift information') }}</h6>
            <div class="pl-lg-4">
              <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name',$shift->name) }}" required autofocus>

                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
              <input type="hidden" name="user_id" value="{{ Auth::id() }}" />

              <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Enter Description">{{ old('description',$shift->description) }}</textarea>
                @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('start_time') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-start_time">{{ __('Shift Starting Time') }}</label>
                <input type="time" name="start_time" id="input-start_time" class="form-control form-control-alternative{{ $errors->has('start_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Time') }}" value="{{ old('start_time',$shift->start_time) }}" required>

                @if ($errors->has('start_time'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('start_time') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('end_time') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-end_time">{{ __('Shift End Time (Number of Hours After Starting Time)') }}</label>
                <input type="number" name="end_time" id="input-end_time" class="form-control form-control-alternative{{ $errors->has('end_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Shift End Time') }}" value="{{ old('end_time',$shift->end_time) }}" required>

                @if ($errors->has('end_time'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('end_time') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('late_time') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-late_time">{{ __('Shift Late Time (Number of Minutes After Starting Time)') }}</label>
                <input type="number" name="late_time" id="input-late_time" class="form-control form-control-alternative{{ $errors->has('late_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Shift Late Time') }}" value="{{ old('late_time',$shift->late_time) }}" required>

                @if ($errors->has('late_time'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('late_time') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('early_go_time') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-early_go_time">{{ __('Shift Early-Go Time (Number of Minutes Before Shift End Time)') }}</label>
                <input type="number" name="early_go_time" id="input-early_go_time" class="form-control form-control-alternative{{ $errors->has('early_go_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Shift Early Go Time') }}" value="{{ old('early_go_time',$shift->early_go_time) }}" required>

                @if ($errors->has('early_go_time'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('early_go_time') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('overtime_start_time') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-overtime_start_time">{{ __('Overtime Start (Number of Minutes After Shift End Time)') }}</label>
                <input type="number" name="overtime_start_time" id="input-overtime_start_time" class="form-control form-control-alternative{{ $errors->has('overtime_start_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Shift Overtime Start') }}" value="{{ old('overtime_start_time',$shift->overtime_start_time) }}" required>

                @if ($errors->has('overtime_start_time'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('overtime_start_time') }}</strong>
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
