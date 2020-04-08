@extends('layouts.app', ['title' => __('Roster')])

@section('head-content')
<link href="http://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
@include('layouts.headers.cards',['noCards' => 1])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Roster') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addToRoster">{{ __('Add Roster Entry') }}</a>
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

        <!--Calendar -->
        <div class="row">
          <div class="col-md-2" style="padding-left:50px;padding-top:10px;text-align:left;">
            Choose Month:
          </div>
          <div class="col-md-4">
            <input type="date" id="chooseMonth" class="form-control"/>
          </div>
        </div>

        <div id="dp" class="row" style="margin-top:20px;padding-bottom:20px;">

        </div>
        <!--Calendar End-->

        <!--Add event/roster entry Modal-->
        <div class="modal fade" id="addToRoster" tabindex="-1" role="dialog" aria-labelledby="addToRosterLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addToRosterLabel">Add To Roster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="form-group" id="errors">
                </div>
                <div class="form-group">
                  <label class="form-control-label" for="input-shift">{{ __('Select Shift') }}</label>
                  <select style="width:100%;" name="shift" id="shift" class="form-control form-control-alternative">
                    @foreach($shifts as $shift)
                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                    @endforeach
                  </select>
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

                <div class="form-group">
                  <label class="form-control-label" for="input-daterange">{{ __('Date Range') }}</label>
                  <input type="text" id="dateRange" class="form-control form-control-alternative" name="dateRange"/>
                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="saveRosterChangesBtn" class="btn btn-primary">Save Changes</button>
              </div>
            </div>
          </div>
        </div>
        <!--End Modal-->

      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<!-- <script src="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.js"></script> -->
<script src="{{ asset('argon') }}/js/roster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){


  // scheduler.init("scheduler_here");
  // scheduler.load("/loadRoster", "json");
  let week = ['Sun','Mon','Tue','Wed','Thur','Fri','Sat'];
  let rosterResources;
  let rosterEvents;
  let dp;

  $.ajax({
    url: "/rosterResources",
    type: "GET",
    dataType: "json",
    success: function(result){

      rosterResources = result;

      $.ajax({
        url: "/loadRoster",
        type: "GET",
        dataType: "json",
        success: function(result2){

          rosterEvents = result2;

          dp = new DayPilot.Scheduler("dp", {
            timeHeaders: [{"groupBy":"Month"},{"groupBy":"Day","format":"d"}],
            onBeforeTimeHeaderRender: function(args) {
              if (args.header.level === 1) {
                var dayOfWeek = args.header.start.getDayOfWeek();
                if (dayOfWeek === 0) {
                  args.header.backColor = "#2ecc71";
                  args.header.cssClass = "sunday";
                }
                args.header.html += ' -'+week[dayOfWeek]+' ';
              }
            },
            scale: "Day",
            days: DayPilot.Date.today().daysInMonth(),
            startDate: DayPilot.Date.today().firstDayOfMonth(),
            endDate: DayPilot.Date.today().lastDayOfMonth(),
            timeRangeSelectedHandling: "Enabled",

            eventDeleteHandling: "Update",
            onEventDeleted: function (args) {
              this.message("Event deleted: " + args.e.text());
            },

            eventHoverHandling: "Bubble",
            bubble: new DayPilot.Bubble({
              onLoad: function(args) {
                // if event object doesn't specify "bubbleHtml" property
                // this onLoad handler will be called to provide the bubble HTML
                args.html = "Event details";
              }
            }),
            treeEnabled: true,
            changeMonth: function(startDate,lastDate){

              $(this)[0].update({
                startDate: startDate,
                endDate: lastDate,
              });
              $('.scheduler_default_corner_inner').next('div').hide();
            },

          });

          dp.resources = rosterResources;
          dp.events.list = rosterEvents;
          dp.init();
          $('.scheduler_default_corner_inner').next('div').hide();

        }
      });

    }
  });

  $('#chooseMonth').change(function(){

    var date = new Date($(this).val());
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 2);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    dp.changeMonth(firstDay,lastDay);
  });


  $('#dateRange').daterangepicker({
    opens: 'center',
    drops: 'up',
  });
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
  $('#saveRosterChangesBtn').click(function(){

    var shift = $('#shift').val();
    if(shift == undefined || shift == null || shift == ""){
      $('#errors').append(errorMsg("You must select a shift!")).delay(2500).fadeOut();
      return;
    }

    var selection = $('#selection').val();
    var selection2 = $('#selection2').val();
    if( (selection == undefined  || selection == null  || selection == "" || selection <0 ) ){
      $('#errors').append(errorMsg("You Must Select Atleast one Department!")).delay(2500).fadeOut();
      return;
    }

    if( (selection2 == undefined  || selection2 == null  || selection2 == "" || selection2 <0 ) ){
      $('#errors').append(Msg("You Must Select Atleast one Employee!")).delay(2500).fadeOut();
      return;
    }

    var daterange = $('#dateRange').val();
    if(daterange == undefined || daterange == null || daterange == ""){
      $('#errors').append(errorMsg("You must define a valid date range")).delay(2500).fadeOut();
      return;
    }

    $.ajax({
      url: "/addToRoster",
      type: "POST",
      dataType: "json",
      data: { shift:shift,selection:selection,selection2:selection2,daterange:daterange },
      success: function(result){

        if(result.status == "Success"){

          $('#errors').html(successMsg(result.message)).delay(1500).queue(function(){

            $(this).fadeOut();
            location.reload();
            $(this).dequeue();
          });
        }else{
          $('#errors').html(errorMsg(result.message)).delay(2500).fadeOut();
        }

      },
      faliure: function(){
        alert('failed');
      }
    });


  });
});


</script>
@endpush
