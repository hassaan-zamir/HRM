

@extends('layouts.app', ['title' => __('Employee Multiple In/Out Report ({{ $date }})')])


@section('content')

@include('layouts.headers.cards')

<!--content -->

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Multiple In/Out Report - {{ $date }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="/" class="btn btn-sm btn-primary">Go Back</a>
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
                <th scope="col" >#</th>
                <th scope="col">Employee Name</th>
                <th scope="col">In-time</th>
                <th scope="col">Repeats</th>
                <th scope="col">Out-time</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($data as $row)


              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row['full_name'] }}</td>
                <td><span style="color:darkblue;">{{ \App\Http\Controllers\HelperController::carbonToTime($row['entries'][count($row['entries'])-1]) }}</span></td>
                <td>
                  @if(count($row['entries']) > 2)
                  @for($i=1;$i<(count($row['entries'])-1);$i++)
                  <span style="color:darkblue">{{ \App\Http\Controllers\HelperController::carbonToTime($row['entries'][$i]) }}&nbsp;</span>
                  @endfor
                  @else
                  N/A
                  @endif
                </td>
                <td>
                  @if(count($row['entries']) > 1)
                  <span style="color:darkblue;">{{ \App\Http\Controllers\HelperController::carbonToTime($row['entries'][0]) }}</span>
                  @else
                  N/A
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
