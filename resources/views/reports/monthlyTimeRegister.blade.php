

@extends('layouts.app', ['title' => __('Monthly Time Register')])

@section('head-content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<style>


@media print {
  @page { 
    size: A4 landscape;
  }

  .printFooter{
    margin-left:20px !important;
    page-break-after: always !important;
  }



  .reportTable{
    margin-right:auto !important;
    margin-left:auto !important;
  }


  .printHide{
    visibility: hidden !important;
  }

  .tdBreak{
    word-break: break-word !important;
    white-space: pre-wrap !important;
  }

  .tdBorderSimple{
    font-size:9px;
    border-top:0.5px solid #000 !important;
    border-left:0.5px solid #000 !important;
    text-align: center !important;
  }

  .tdBorderBottom{
    border-bottom: 0.5px solid #000 !important;
  }

  .tdBorderRight{
    border-right: 0.5px solid #000 !important;
  }
}
</style>
@endsection

@section('content')

@include('layouts.headers.cards')

<!--content -->

<div class="container-fluid mt--7" id="mainContainer">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0" id="heading">Employees Monthly Time Register({{ \App\Http\Controllers\HelperController::monthOfYear($month) }} {{ $year }})</h3>
            </div>
            <div class="col-4 text-right">
              <a href="#" id="printBtn" class="btn btn-sm btn-primary printHide">Print</a>
              <a href="/" class="btn btn-sm btn-primary printHide">Go Back</a>
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

        <div class="table-responsive" id="parentDiv">
        <table class="table-sm align-items-center table-flush display reportTable" id="reportTable" cellspacing="0" cellpadding="0" style="float:none;" >

            <thead class="thead-dark">
              <tr>
                <th class="tdBorderSimple">Id</th>
                <th class="tdBorderSimple" colspan="2">Name</th>
                @for($i=1;$i<=$totalDays;$i++)
                <th class="{{ ($i==$totalDays)?'tdBorderRight':'' }} tdBorderSimple">{!! \App\Http\Controllers\HelperController::dateWeekFormat($i,$month,$year,'<br>') !!}</th>
                @endfor
              </tr>
            </thead>

            <tbody style="float:none;">
              @foreach($employeeReports as $employeeReport)

              @if($loop->last)
              <?php $tdClass = 'tdBorderSimple'; $tdClass2= ' tdBorderBottom'; ?>
              @else
              <?php $tdClass = 'tdBorderSimple'; $tdClass2= ''; ?>
              @endif
              
              <tr>
                <td class="{{ $tdClass }}" rowspan="3">{{ \App\Http\Controllers\HelperController::employeeCode($employeeReport['employee']['machine_id']) }}</td>
                <td class="{{ $tdClass }} tdBreak" rowspan="3">{!! str_replace(' ','<br>',$employeeReport['employee']['full_name']) !!}</td>
                <td class="{{ $tdClass }}">
                  <b>In</b>
                </td>
                @for($i=0;$i<$totalDays;$i++)
                <td class="{{ ($i==$totalDays-1)?'tdBorderRight':'' }} {{ $tdClass }}">
                  {{ \App\Http\Controllers\HelperController::neverEmpty($employeeReport['rows'][$i]['in_time']) }}
                </td>
                @endfor

              </tr>     
              <tr>
                <td class="{{ $tdClass }}"><b>Out</b></td>
                @for($i=0;$i<$totalDays;$i++)
                <td class="{{ ($i==$totalDays-1)?'tdBorderRight':'' }} {{ $tdClass }}">
                  {{ \App\Http\Controllers\HelperController::neverEmpty($employeeReport['rows'][$i]['out_time']) }}
                </td>
                @endfor
              </tr>

              <tr>
                <td class="{{ $tdClass }}"><b>OT</b></td>
                @for($i=0;$i<$totalDays;$i++)
                <td class="{{ ($i==$totalDays-1)?'tdBorderRight':'' }} {{ $tdClass }}">
                {{ \App\Http\Controllers\HelperController::neverEmpty(\App\Http\Controllers\HelperController::secondsToClock($employeeReport['rows'][$i]['ot'])) }}
                </td>
                @endfor
              </tr>

              <tr class="{{ ($loop->iteration%7==0 && $loop->iteration != 0 && !$loop->last)?'pageBreak':'' }}" >
                
                <td class="{{ $tdClass }}{{ $tdClass2 }}" colspan="3">Summary</td>

                @for($i=0;$i<count($employeeReport['summaryHeadings']);$i++)
                <td class="{{ $tdClass }}{{ $tdClass2 }}">
                  <b>{{ $employeeReport['summaryHeadings'][$i] }}</b>                    
                </td>
                <td class="{{ $tdClass }}{{ $tdClass2 }}">
                  <i>{{ $employeeReport['summaryResults'][$i] }}</i>                
                </td>
                @endfor
                <td colspan= "{{ $totalDays - count($employeeReport['summaryHeadings'])*2 }}" class="{{ $tdClass }}{{ $tdClass2 }} tdBorderRight"></td>
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

@push('js')
<script>
$(document).ready( function () {


    let reportTable = $('#reportTable');
    try{

      reportTable.DataTable({
        dom: 'Bftrip',
        buttons: [
          'print',
          'excelHtml5'
        ],
        "pageLength": 31,
      });

    }catch(e){

    }

    
    let theadTagHtml = '<thead class="thead-dark">'
    let theadHtml = $('.thead-dark').html();
    let headerText = $('#heading').html();
    let pageHeader = '<h3 class="mb-0" style="padding-left:20px;padding-bottom:10px;" >'+headerText+'</h3>';
  

    $('#printBtn').click(function(){
     
      reportTable.removeClass('dataTable');

      var totalPage = $('.pageBreak').length;
      var page = 1;

      

      for(var i=0;i<totalPage;i++){

        if(i == 0){
          var $breakTable = $("#reportTable");
        }else{
          var $breakTable = $("#breakTable"+(i-1));
        }
        var tableTagHtml = '<table class="table-sm align-items-center table-flush display reportTable" id="breakTable'+i+'" cellspacing="0" cellpadding="0" style="float:none;" >';
        var splitBy = 28;
        var rows = $breakTable.find ( "tbody tr" ).slice( splitBy );
        var pageFooter = '<p class="printFooter"><b>Page '+page+' of '+(totalPage+1)+'</p></p>';
        var appendHtml = "<br>"+pageFooter+"<br>"+pageHeader+tableTagHtml+theadTagHtml+theadHtml+"</thead><tbody></tbody></table>";
        
        if(i == totalPage-1){
          appendHtml += "<br><p class='printFooter'><b>Page "+(page+1)+" of "+(totalPage+1)+"</b></p>";
        }
        $("#parentDiv").append(appendHtml);
        $('#breakTable'+i).find("tbody").append(rows);
        //$breakTable.find ( "tbody tr" ).slice( splitBy ).remove();
        page++;
        
      }

      $('#sidenav-main').remove();
      $('#navbar-main').remove();
      $('#cardsHeader').remove();
      $('.footer').remove();
      $('#mainContainer').addClass('printTime').removeClass('container-fluid');
      window.print();
    });

} );
</script>
@endpush
