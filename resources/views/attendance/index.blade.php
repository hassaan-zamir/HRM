@extends('layouts.app', ['title' => __('Attendance Management')])

@section('head-content')
<link href="http://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
@include('attendance.partials.header', ['title' => __('Attendance')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Manual Attendance') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="#" class="btn btn-sm btn-primary">Dummy</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('attendance.view') }}" autocomplete="off">
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

            <h6 class="heading-small text-muted mb-4">{{ __('Manual Attendance') }}</h6>
            <div class="pl-lg-4">

              <div class="form-group" id="errors">
              </div>

              <div class="form-group">
                <label class="form-control-lable">Select Date</label>
                <input name="date" type="date" class="form-control" required value="{{ old('date') }}" />
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-selection">Select Department(s)</label>
                <select style="width:100%;" name="departmentSelection[]" id="selection" class="form-control form-control-alternative" multiple="multiple">
                  <optgroup label="">
                    @if(count($departments) > 0)
                    <option value="0"><b>All Departments</b></option>
                    @endif
                    @foreach($departments as $department)
                    <option class="departmentOption" value="{{$department->id}}">{{ $department->name }}</option>
                    @endforeach
                  </optgroup>
                </select>

                <div id="selection2Div">
                  <label class="form-control-label" for="input-selection2">Select Employee(s)</label>
                  <select style="width:100%;display:none;" name="employeeSelection[]" id="selection2" class="form-control form-control-alternative" multiple="multiple">
                    <optgroup label="Employees">
                      @if(count($employees) > 0)
                      <option value="0"><b>All Employees</b></option>
                      @endif
                      @foreach($employees as $employee)
                      <option class="employeeOption" department="{{$employee->department}}" value="{{$employee->id}}">

                        @if($employee->id<10)
                        Emp-00{{ $employee->id }} - {{ $employee->full_name }}
                        @elseif($employee->id<100)
                        Emp-0{{ $employee->id }} - {{ $employee->full_name }}
                        @else
                        Emp-{{ $employee->id }} - {{ $employee->full_name }}
                        @endif

                      </option>
                      @endforeach
                    </optgroup>
                  </select>
                </div>
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

@push('js')
<script src="{{ asset('argon') }}/js/roster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){



  $('#selection').select2({
    placeholder: 'Select an Department',
  });

  $('#selection2').select2({
    placeholder: 'Select an Employee',
  });

  $('#selection2Div').hide();

  $('#selection').change(function(){

    var departments = $(this).val();
    //if department chosen then show employees
    if(departments.length > 0){
      $('#selection2Div').fadeIn();
    }else{// if department removed then hide employees also refresh department select2
      $('#selection2Div').fadeOut();
      $('#selection').select2();
    }
    //Enable but deselect all employees
    $('.employeeOption').prop("selected",false).removeAttr('disabled');
    //Reset Select2 of all employees
    $('#selection2').select2();


    if(jQuery.inArray('0', departments) !== -1){//after change if all department was selected
      //deselect any other department selection and refresh select2
      $('.departmentOption').prop("selected", false);
      $('#selection').select2();
    }else{
      //show employees of chosen department only
      $('.employeeOption').each(function(){

        var emp_department = $(this).attr('department');
        if(jQuery.inArray(emp_department, departments) == -1){
          $(this).attr('disabled','disabled');
        }
      });
    }


  });

  $('#selection2').change(function(){
    var employees = $(this).val();
    if(jQuery.inArray('0',employees) !== -1){
      $('.employeeOption').prop("selected",false);
      $('#selection2').select2();
    }
  });

  function errorMsg(message){
    return "<div class=\"alert alert-danger\" role=\"alert\">"+message+"</div>";
  }
  function successMsg(message){
    return "<div class=\"alert alert-success\" role=\"alert\">"+message+"</div>";
  }
  
});


</script>
@endpush
