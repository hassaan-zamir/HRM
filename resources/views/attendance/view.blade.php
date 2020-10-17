@extends('layouts.app', ['title' => __('Attendance')])

@section('head-content')
<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
@endsection

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Attendance') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a id="saveChanges" style="display:none" href="#" class="btn btn-sm btn-primary">Save Changes</a>
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
        <input type="hidden" value="{{ $date }}" id="date" >

        <div class="table-responsive">
          <table class="display table align-items-center table-flush" id="attendanceTable" cellspacing="0" width="100%">
            <thead class="thead-light">
              <tr>
                <th scope="col">Employee Code</th>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">In-time</th>
                <th scope="col">Out-Time</th>
                <th scope="col">Calculated Overtime</th>
                <th scope="col">Manual Overtime</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              @foreach ($data as $row)
              <?php $i++; ?>
              <tr>
                <td>
                  @if($row['machineId']<10)
                  Emp-00{{ $row['machineId'] }}
                  @elseif($row['machineId']<100)
                  Emp-0{{ $row['machineId'] }}
                  @else
                  Emp-{{ $row['machineId'] }}
                  @endif
                </td>
                <td class="editable">
                  <span class="txt" row="{{ $row['e_code'] }}" label="name">{{ $row['name'] }}</span>
                  <span class="editField" style="display:none;">
                    <input type="text" class="form-control editableInp" value="{{ $row['name'] }}" row="{{ $row['e_code'] }}" label="name">
                  </span>
                </td>
                <td class="editable" >
                  <span class="txt" row="{{ $row['e_code'] }}" label="department">{{ $row['department'] }}</span>
                  <span class="editField" style="display:none;">
                    <input type="text" class="form-control editableInp" value="{{ $row['department'] }}" row="{{ $row['e_code'] }}" label="department">
                    <input type="hidden" row="{{ $row['e_code'] }}" label="dayStart" value="{{ $row['shift_details']['day_start'] }}" />
                  </span>
                </td>
                <td class="editable" >
                  <span class="txt" row="{{ $row['e_code'] }}" label="in_time">
                    @if($row['in_time'] != null )
                    {{ \App\Http\Controllers\HelperController::carbonToTime($row['in_time'],'') }}
                    @endif
                  </span>
                  <span class="editField" style="display:none;">
                    <input type="text" class="editableInp" placeholder="e.g 0900" {{ ($row['shift_details']==null)?'disabled="disabled"':'' }} value="{{ \App\Http\Controllers\HelperController::carbonToTime($row['in_time'],'') }}"   row="{{ $row['e_code'] }}" label="in_time" antilabel="worked_duration">

                    <span class="error-box" style="color:red;">
                    </span>
                  </span>
                </td>
                <td class="editable" >
                  <span class="txt" row="{{ $row['e_code'] }}" label="worked_duration">
                    @if($row['out_time'] != null)
                    {{ \App\Http\Controllers\HelperController::carbonToTime($row['out_time'],'') }}
                    @endif
                  </span>
                  <span class="editField" style="display:none;">
                    <input type="text"  placeholder="e.g 0900" {{ ($row['shift_details']==null)?'disabled="disabled"':'' }} class="editableInp" value="@if($row['worked_duration'] && $row['in_time']){{ \App\Http\Controllers\HelperController::carbonToTime($row['in_time']->copy()->addSeconds($row['worked_duration']),'') }}@endif"  row="{{ $row['e_code'] }}" label="worked_duration" antilabel="in_time" >

                    <span class="error-box" style="color:red;">

                    </span>
                  </span>
                </td>
                <td>
                  <span class="txt">{{ $row['calc_ot'] }}</span>
                </td>
                <td class="editable">
                  <span class="txt" row="{{ $row['e_code'] }}" label="man_ot">{{ $row['man_ot'] }}</span>
                  <span class="editField" style="display:none;">
                    <input type="number" name="man_ot_hr" style="width:40px;" class="editableInp" value="{{ $row['man_ot_hr'] }}" placeholder="hr" row="{{ $row['e_code'] }}" label="man_ot">hr
                    <input type="number" name="man_ot_min" style="width:40px;" class="editableInp" value="{{ $row['man_ot_min'] }}" placeholder="min" row="{{ $row['e_code'] }}" label="man_ot"> min
                    <input type="number" name="man_ot_sec" style="width:40px;" class="editableInp" value="{{ $row['man_ot_sec'] }}" placeholder="sec" row="{{ $row['e_code'] }}" label="man_ot"> sec
                  </span>
                </td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


                    </div>
                  </div>
                </td>
              </tr>

              @endforeach
            </tbody>
          </table>
          <div id="testing"></div>
        </div>

      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>

let changes = [];

$(document).ready(function() {

  let clickCheck = 0;

  $('#attendanceTable').DataTable();

  $(document).on("click", ".editable" , function(e) {

    clickCheck = 1;
    $('.txt').show();
    $('.editField').hide();
    $(this).find('.txt').hide();
    $(this).find('.editField').show();
    //$(this).find('.editField input:first').focus();

  });

  $(document).click(function(){
    if(!clickCheck){
      $('.txt').show();
      $('.editField').hide();
    }
    clickCheck = 0;
  });


  $(document).on("keyup",".editableInp", function() {

    $('#saveChanges').show();
    $(this).next('.error-box').html('');
    var allGood = 1;
    var label = $(this).attr('label');
    var antilabel = $(this).attr('antilabel');
    var e_code = $(this).attr('row');
    var val = $(this).val();
    let antival;
    var date = $('#date').val();
    if(date!= undefined || date!="" || date!=null){


      if(label=="in_time" || label == "worked_duration"){


        antival = $('.editableInp[label="'+antilabel+'"][row="'+e_code+'"]').val();
        if(RegExp("^[0-2][0-9][0-6][0-9]$").test(val) || val == "0000"){

          $('.txt[label="'+label+'"][row="'+e_code+'"]').html(val);

        }else{
          console.log(val);
          $(this).next('.error-box').html('format not matched');
          allGood = 0;
        }


      }else if(label == "man_ot"){
        var name = $(this).attr('name');
        var html = $('.txt[label="'+label+'"][row="'+e_code+'"]').html();
        var hr = min = sec = '0';
        if(html != ''){
          html = html.split(':');
          hr = html[0]; min = html[1]; sec = html[2];
        }

        if(name == 'man_ot_hr'){
          hr = val;
        }else if(name == 'man_ot_min'){
          min = val;
        }else if(name == 'man_ot_sec'){
          sec = val;
        }
        $('.txt[label="'+label+'"][row="'+e_code+'"]').html(hr+':'+min+':'+sec);
        val = (parseInt(hr)*60*60)+(parseInt(min)*60)+(parseInt(sec));
      }


      if(allGood){

        var existCheck = 0;
        var i;
        for(i=0;i<changes.length;i++){
          var item = changes[i];
          if(item['e_code'] == e_code){
            item[label] = val;
            if(antival.length == 4 || antival.length == 0){
              item[antilabel] = antival;
            }
            item['date'] = date;
            existCheck = 1;
          }

        }

        if(existCheck == 0){
          var append = {};
          append['e_code'] = e_code;
          append['date'] = date;
          append[label] = val;
          if(antival.length == 4 || antival.length == 0){
            append[antilabel] = antival;
          }
          append['dayStart'] = $('input[label="dayStart"][row="'+e_code+'"]').val();
          changes.push(append);
        }
        console.log(changes);
      }else{
        $('.txt[label="'+label+'"][row="'+e_code+'"]').html('');
      }

    }

  });

  $(document).on("click","#saveChanges",function(){
    var date = $('#date').val();
    $.ajax({
      url: "/saveAttendanceChanges",
      type: "POST",
      dataType: "json",
      data: {changes:changes,date:date},
      success: function(result){
        //$('#testing').html(result);
        console.log(result);
        if(result.status == "Success"){
          alert('Success : ' + result.message);
        }else{
          alert('Error : ' + result.message);
        }

      }
    });
  });

});
</script>
@endpush
