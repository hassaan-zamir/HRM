@extends('layouts.app', ['title' => __('Leaves Management')])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Employee Leaves') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('leaves.create') }}" class="btn btn-sm btn-primary">{{ __('Add Leave') }}</a>
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
                <th scope="col">{{ __('Employee') }}</th>
                <th scope="col">{{ __('Start Date') }}</th>
                <th scope="col">{{ __('End Date') }}</th>
                <th scope="col">{{ __('Subject') }}</th>
                <th scope="col">{{ __('Description') }}</th>
                <th scope="col">{{ __('Type') }}</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($leaves as $leave)
              <tr>
                <td>{{ App\Employees::where('id','=',$leave->emp_id)->first()->full_name }}</td>
                <td>{{ \App\Http\Controllers\HelperController::carbonToDate($leave->start_date) }}</td>
                <td>{{ \App\Http\Controllers\HelperController::carbonToDate($leave->leave_date) }}</td>
                <td>{{ $leave->subject }}</td>
                <td>{{ $leave->description }}</td>
                <td>
                  {{ $leave->type }}
                </td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                      <form action="{{ route('leaves.destroy', $leave) }}" method="post">
                        @csrf
                        @method('delete')

                        <a class="dropdown-item" href="{{ route('leaves.edit', $leave) }}">{{ __('Edit') }}</a>
                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this leave?") }}') ? this.parentElement.submit() : ''">
                          {{ __('Delete') }}
                        </button>
                      </form>

                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4">
          <nav class="d-flex justify-content-end" aria-label="...">
            {{ $leaves->links() }}
          </nav>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection
