@extends('layouts.app', ['title' => __('Leaves Management')])

@section('content')
@include('leaves.public.partials.header', ['title' => __('Edit Public Holiday')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Public Holiday Management') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('publicHolidays.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('publicHolidays.update', $publicHoliday) }}" autocomplete="off">
            @csrf
            @method('put')

            <h6 class="heading-small text-muted mb-4">{{ __('Holiday information') }}</h6>
            <div class="pl-lg-4">
              <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-date">{{ __('Date') }}</label>
                <input type="date" name="date" id="input-date" class="form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="{{ __('Date') }}" value="{{ old('date',$publicHoliday->date) }}" required autofocus>

                @if ($errors->has('date'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('date') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-title">{{ __('Holiday Title/Name') }}</label>
                <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title',$publicHoliday->title) }}" required >

                @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description',$publicHoliday->description) }}</textarea>

                @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
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
