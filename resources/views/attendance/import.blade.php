@extends('layouts.app', ['title' => __('Attendance Management')])

@section('head-content')

@endsection

@section('content')
@include('attendance.partials.header', ['title' => __('Import Attendance')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Import Attendance') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
          </div>
        </div>


        <div class="card-body">



          <form method="post" action="{{ route('attendance.import') }}" autocomplete="off" enctype="multipart/form-data">
            @csrf

            <h6 class="heading-small text-muted mb-4">{{ __('Import Attendance') }}</h6>
            <div class="pl-lg-4">

              <div class="form-group">
                @if (isset($status))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ $status }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
              </div>
              <div class="form-group">
                <label class="form-control-label" for="input-ip">{{ __('Import File') }}</label>
                <input type="file" name="importFile" id="input-ip" class="form-control form-control-alternative" placeholder="{{ __('Import File') }}"  required >
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-from">{{ __('From') }}</label>
                <input type="date" name="from" id="input-from" class="form-control form-control-alternative" placeholder="{{ __('From') }}" value="{{ old('from') }}" required >
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-till">{{ __('Till') }}</label>
                <input type="date" name="till" id="input-till" class="form-control form-control-alternative" placeholder="{{ __('Till') }}" value="{{ old('till') }}" required >
              </div>

            </div>


            <div class="text-center">
              <button type="submit" class="btn btn-success mt-4">{{ __('Import') }}</button>
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

@push('js')

@endpush
