@extends('layouts.app', ['title' => __('Employee Management')])

@section('content')
    @include('employee.partials.header', ['title' => __('Add Employee')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Employee Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('employee.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="{{ route('employee.store') }}" autocomplete="off" style="margin-top:20px;">
                      <div class="panel-group" id="accordion">


                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a id="mainDataCollapseLink" class="collapseLink" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                             Basic Information</a><small> (Must Fill Out)</small>
                           </h4>
                         </div>
                         <div id="collapse1" class="panel-collapse collapse in show">
                           <div class="panel-body">

                             @include('employee.partials.forms.main')

                           </div>
                         </div>
                        </div>


                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a data-toggle="collapse" class="collapseLink" data-parent="#accordion" href="#collapse2">
                             Personal Details</a><small> (Optional - can be filled later) </small>
                           </h4>
                         </div>
                         <div id="collapse2" class="panel-collapse collapse">
                           <div class="panel-body">
                             @include('employee.partials.forms.personalDetails')
                           </div>
                         </div>
                        </div>


                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a data-toggle="collapse" class="collapseLink" data-parent="#accordion" href="#collapse3">
                             Salary</a><small> (Optional - can be filled later) </small>
                           </h4>
                         </div>
                         <div id="collapse3" class="panel-collapse collapse">
                           <div class="panel-body">
                             @include('employee.partials.forms.salaryDetails')
                           </div>
                         </div>
                        </div>

                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a data-toggle="collapse" class="collapseLink" data-parent="#accordion" href="#collapse4">
                             Contact</a><small> (Optional - can be filled later) </small>
                           </h4>
                         </div>
                         <div id="collapse4" class="panel-collapse collapse">
                           <div class="panel-body">
                             @include('employee.partials.forms.contactDetails')
                           </div>
                         </div>
                        </div>

                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a data-toggle="collapse" class="collapseLink" data-parent="#accordion" href="#collapse5">
                             Emergency Contact</a><small> (Optional - can be filled later) </small>
                           </h4>
                         </div>
                         <div id="collapse5" class="panel-collapse collapse">
                           <div class="panel-body">
                             @include('employee.partials.forms.emergencyDetails')
                           </div>
                         </div>
                        </div>

                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a data-toggle="collapse" class="collapseLink" data-parent="#accordion" href="#collapse6">
                             Work Experience</a><small> (Optional - can be filled later) </small>
                           </h4>
                         </div>
                         <div id="collapse6" class="panel-collapse collapse">
                           <div class="panel-body">
                             @include('employee.partials.forms.workExperienceDetails')
                           </div>
                         </div>
                        </div>

                        <div class="panel panel-default">
                         <div class="panel-heading">
                           <h4 class="panel-title">
                             <a data-toggle="collapse" class="collapseLink" data-parent="#accordion" href="#collapse7">
                             Qualifications</a><small> (Optional - can be filled later) </small>
                           </h4>
                         </div>
                         <div id="collapse7" class="panel-collapse collapse">
                           <div class="panel-body">
                             @include('employee.partials.forms.qualificationDetails')
                           </div>
                         </div>
                        </div>


                      </div>

                      <div class="text-center">
                          <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                      </div>

                    </form>

                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>

    <script>
    $(document).ready(function(){
      $('.collapseLink').click(function(){

        href = $(this).attr('href').substring(1);

        $('.collapse').each(function(){

          id = $(this).attr('id');
          if($(this).hasClass("show") && href!=id){
            $(this).removeClass("show");
          }
        });

      });

      $('#cloneWorkExpBtn').click(function(){

        var html = $('#clone').html();
        $('.workExperienceDiv').append('<hr><h6>New entry</h6>').append(html);

      });

      $('#cloneQualificationsBtn').click(function(){

        var html = $('#clone2').html();
        $('.qualificationsDiv').append('<hr><h6>New entry</h6>').append(html);

      });
    });
    </script>
@endsection
