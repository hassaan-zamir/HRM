@extends('layouts.app', ['title' => __('Designation Management')])

@section('content')
@include('designation.partials.header', ['title' => __('Add Designation')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Designation Management') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('designation.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('designation.store') }}" autocomplete="off">
            @csrf

            <h6 class="heading-small text-muted mb-4">{{ __('Designation information') }}</h6>
            <div class="pl-lg-4">
              <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title') }}" required autofocus>

                @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('detail') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-details">{{ __('Detail') }}</label>
                <textarea name="detail" id="input-detail" class="form-control form-control-alternative{{ $errors->has('detail') ? ' is-invalid' : '' }}" >{{ old('detail') }}</textarea>

                @if ($errors->has('detail'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('detail') }}</strong>
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
