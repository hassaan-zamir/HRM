@extends('layouts.app', ['title' => __('Shift Management')])

@section('content')
@include('shift.partials.header', ['title' => __('Edit Shift')])

<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Shift Management') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('shift.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('shift.update',$shift->id) }}" autocomplete="off">
            @csrf
            @method('put')

            @if(count($errors) > 0)
            <div class="alert alert-danger" role="alert">
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <h6 class="heading-small text-muted mb-4">{{ __('Shift information') }}</h6>
            <div class="pl-lg-4">

              <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name',$shift->name) }}" required autofocus>
              </div>
              <input type="hidden" name="user_id" value="{{ Auth::id() }}" />

              <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Enter Description">{{ old('description',$shift->description) }}</textarea>
              </div>


              <div class="form-group{{ $errors->has('day_start_hr','day_start_min') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-start_time">{{ __('Shift Day Starting Time') }}</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="day_start_hr" class="form-control form-control-alternative{{ $errors->has('day_start_hr') ? ' is-invalid' : '' }}">
                      @for($i=1;$i<=24;$i++)
                      <option value="{{ $i }}" {{ ($i==date('H',strtotime($shift->day_start)) )?'selected="selected"':'' }}>{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                  <span style="margin-top:8px;">:</span>
                  <div class="col-md-6">
                    <select name="day_start_min" class="form-control form-control-alternative{{ $errors->has('day_start_min') ? ' is-invalid' : '' }}">
                      @for($i=0;$i<=60;$i++)
                      <option value="{{ $i }}" {{ ( $i==(date('i',strtotime($shift->day_start))) )?'selected="selected"':''}} >
                        @if($i < 10)
                        0{{ $i }}
                        @else
                        {{ $i }}
                        @endif

                      </option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group{{ $errors->has('start_time_hr','start_time_min') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-start_time">{{ __('Shift Starting Time') }}</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="start_time_hr" class="form-control form-control-alternative{{ $errors->has('start_time_hr') ? ' is-invalid' : '' }}">
                      @for($i=1;$i<=24;$i++)
                      <option value="{{ $i }}" {{ ($i==date('H',strtotime($shift->start_time)) )?'selected="selected"':'' }}>{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                  <span style="margin-top:8px;">:</span>
                  <div class="col-md-6">
                    <select name="start_time_min" class="form-control form-control-alternative{{ $errors->has('start_time_min') ? ' is-invalid' : '' }}">
                      @for($i=0;$i<=60;$i++)
                      <option value="{{ $i }}" {{ ($i==date('i',strtotime($shift->start_time)) )?'selected="selected"':''}} >
                        @if($i < 10)
                        0{{ $i }}
                        @else
                        {{ ($i==date('i',strtotime($shift->start_time)) )?'selected="selected"':''}}
                        {{ $i }}
                        @endif

                      </option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group{{ $errors->has('duration_hour','duration_mins') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-end_time">{{ __('Shift Duration') }}</label>
                <div class="row">
                  <div class="col-md-6">
                    <input type="number" name="duration_hour" id="input-duration_hour" class="form-control  form-control-alternative{{ $errors->has('duration_hour') ? ' is-invalid' : '' }}" placeholder="{{ __('Hrs') }}" value="{{ old('duration_hour', \App\Http\Controllers\HelperController::floatToHours($shift->shift_duration) ) }}" required>
                  </div>
                  <div class="col-md-6">
                    <input type="number" name="duration_mins" id="input-duration_mins" class="form-control form-control-alternative{{ $errors->has('duration_mins') ? ' is-invalid' : '' }}" placeholder="{{ __('Mins') }}" value="{{ old('duration_mins', \App\Http\Controllers\HelperController::floatToMinutes($shift->shift_duration) ) }}" required>
                  </div>
                </div>

              </div>


              <div class="form-group{{ $errors->has('lunch_duration_hours','lunch_duration_mins') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-end_time">{{ __('Lunch Duration') }}</label>
                <div class="row">
                  <div class="col-md-6">
                    <input type="number" name="lunch_duration_hour" id="input-lunch-duration_hour" class="form-control  form-control-alternative{{ $errors->has('lunch_duration_hour') ? ' is-invalid' : '' }}" placeholder="{{ __('Hrs') }}" value="{{ old('lunch_duration_hour',\App\Http\Controllers\HelperController::floatToHours($shift->lunch_duration) ) }}" required>
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="lunch_duration_mins" id="input-lunch-duration_mins" class="form-control form-control-alternative{{ $errors->has('lunch_duration_mins') ? ' is-invalid' : '' }}" placeholder="{{ __('Mins') }}" value="{{ old('lunch_duration_mins',\App\Http\Controllers\HelperController::floatToMinutes($shift->lunch_duration) ) }}" required>
                  </div>
                </div>

              </div>

              <div class="form-group{{ $errors->has('late_duration_hour','late_duration_mins') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-late_duration">{{ __('Shift Late Duration') }}</label>
                <br>
                <input type="number" name="late_duration_hour" id="input-late_duration_hour" class="col-md-3  form-control-alternative{{ $errors->has('late_duration_hour') ? ' is-invalid' : '' }}" placeholder="{{ __('Hrs') }}" value="{{ old('late_duration_hour',\App\Http\Controllers\HelperController::floatToHours($shift->late_time)) }}" required> Hrs
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" name="late_duration_mins" id="input-late_duration_mins" class="col-md-3 form-control-alternative{{ $errors->has('late_duration_mins') ? ' is-invalid' : '' }}" placeholder="{{ __('Mins') }}" value="{{ old('late_duration_mins',\App\Http\Controllers\HelperController::floatToMinutes($shift->late_time)) }}" required> Mins
              </div>

              <div class="form-group{{ $errors->has('early_duration_hour','early_duration_mins') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-early_go_time">{{ __('Early-Go Duration') }}</label>
                <br>
                <input type="number" name="early_duration_hour" id="input-early_duration_hour" class="col-md-3  form-control-alternative{{ $errors->has('early_duration_hour') ? ' is-invalid' : '' }}" placeholder="{{ __('Hrs') }}" value="{{ old('early_duration_hour',\App\Http\Controllers\HelperController::floatToHours($shift->early_go_time)) }}" required> Hrs
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" name="early_duration_mins" id="input-early_duration_mins" class="col-md-3 form-control-alternative{{ $errors->has('early_duration_mins') ? ' is-invalid' : '' }}" placeholder="{{ __('Mins') }}" value="{{ old('early_duration_mins',\App\Http\Controllers\HelperController::floatToMinutes($shift->early_go_time)) }}" required> Mins
              </div>

              <div class="form-group{{ $errors->has('overtime_duration_hour','overtime_duration_mins') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-overtime_start_time">{{ __('Minimum Overtime Count') }}</label>
                <br>
                <input type="number" name="overtime_duration_hour" id="input-overtime_duration_hour" class="col-md-3  form-control-alternative{{ $errors->has('overtime_duration_hour') ? ' is-invalid' : '' }}" placeholder="{{ __('Hrs') }}" value="{{ old('overtime_duration_hour',\App\Http\Controllers\HelperController::floatToHours($shift->overtime_start_time)) }}" required> Hrs
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" name="overtime_duration_mins" id="input-overtime_duration_mins" class="col-md-3 form-control-alternative{{ $errors->has('overtime_duration_mins') ? ' is-invalid' : '' }}" placeholder="{{ __('Mins') }}" value="{{ old('overtime_duration_mins',\App\Http\Controllers\HelperController::floatToMinutes($shift->overtime_start_time)) }}" required> Mins
              </div>

              <div class="form-group{{ $errors->has('sunday_check') ? ' has-danger' : '' }}">
                <div class="row">
                  <div class="col-md-3">
                    <input type="checkbox" id="sunday_check_parent" name="sunday_check_parent" value="0" /> Treat Sunday as Holiday
                  </div>
                </div>
                <div class="row furtherOptions" style="display:none;">
                  <input type="radio" name="sunday_check" value="0" style="display:none;" checked="checked"/>
                  <div class="col-md-3">
                    <input type="radio" id="sunday_check_op1" name="sunday_check" value="1" /> Holiday with same timings
                  </div>
                  <div class="col-md-3">
                    <input type="radio" id="sunday_check_op2" name="sunday_check" value="2" /> Holiday with new timings
                  </div>
                </div>
                <div class="row">

                  @if ($errors->has('sunday_check'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sunday_check') }}</strong>
                  </span>
                  @endif

                </div>

              </div>

              <div class="hiddenPart"
              @if( old('sunday_check') !== null)
              @if( old('sunday_check') != 2)
              style="display:none;"
              @endif
              @else
              style="display:none;"
              @endif
              >

              <div class="form-group">
                <label class="form-control-label">Sunday Starting Time{{ old('sunday_check') }}</label>
                <div class="row">
                  <div class="col-md-4">
                    <select name="sunday_start_time_hr" class="form-control">
                      @for($i=1;$i<=24;$i++)
                      <option value="{{ $i }}" {{ ($i==date('H',strtotime($shift->sunday_start_time)) )?'selected="selected"':'' }} >{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                  <span style="margin-top:8px;">:</span>
                  <div class="col-md-6">
                    <select name="sunday_start_time_min" class="form-control">
                      @for($i=0;$i<=60;$i++)
                      <option value="{{ $i }}" {{ ($i==date('i',strtotime($shift->sunday_start_time)) )?'selected="selected"':''}}>
                        @if($i < 10)
                        0{{ $i }}
                        @else
                        {{ $i }}
                        @endif
                      </option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label" >Sunday Shift Duration</label>
                <div class="row">
                  <div class="col-md-6">
                    <input type="number" name="sunday_duration_hour" class="form-control" placeholder="{{ __('Hrs') }}" value="{{ old('sunday_duration_hour', \App\Http\Controllers\HelperController::floatToHours($shift->sunday_shift_duration) ) }}">
                  </div>
                  <div class="col-md-6">
                    <input type="number" name="sunday_duration_mins" class="form-control" placeholder="{{ __('Mins') }}" value="{{ old('sunday_duration_mins' ,\App\Http\Controllers\HelperController::floatToMinutes($shift->sunday_shift_duration) ) }}">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label" >Sunday Lunch Duration</label>
                <div class="row">
                  <div class="col-md-6">
                    <input type="number" name="sunday_lunch_duration_hour" class="form-control" placeholder="{{ __('Hrs') }}" value="{{ old('sunday_lunch_duration_hour',\App\Http\Controllers\HelperController::floatToHours($shift->sunday_lunch_duration) ) }}">
                  </div>
                  <div class="col-md-6">
                    <input type="number" name="sunday_lunch_duration_mins" class="form-control" placeholder="{{ __('Mins') }}" value="{{ old('sunday_lunch_duration_mins', \App\Http\Controllers\HelperController::floatToMinutes($shift->sunday_lunch_duration)) }}">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label" >Sunday Late Duration</label>
                <br>
                <input type="number" name="sunday_late_duration_hour" class="col-md-3" placeholder="{{ __('Hrs') }}" value="{{ old('sunday_late_duration_hour', \App\Http\Controllers\HelperController::floatToHours($shift->sunday_late_time)) }}"> Hrs
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" name="sunday_late_duration_mins" class="col-md-3" placeholder="{{ __('Mins') }}" value="{{ old('sunday_late_duration_mins', \App\Http\Controllers\HelperController::floatToMinutes($shift->sunday_late_time)) }}"> Mins
              </div>

              <div class="form-group">
                <label  class="form-control-label">Sunday Early-Go Duration</label>
                <br>
                <input type="number" name="sunday_early_duration_hour" class="col-md-3" placeholder="{{ __('Hrs') }}" value="{{ old('sunday_early_duration_hour',\App\Http\Controllers\HelperController::floatToHours($shift->sunday_early_go_time) ) }}"> Hrs
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" name="sunday_early_duration_mins" class="col-md-3" placeholder="{{ __('Mins') }}" value="{{ old('sunday_early_duration_mins',\App\Http\Controllers\HelperController::floatToMinutes($shift->sunday_early_go_time) ) }}"> Mins
              </div>

              <div class="form-group">
                <label class="form-control-label">Sunday Minimum Overtime count</label>
                <br>
                <input type="number" name="sunday_overtime_duration_hour" class="col-md-3" placeholder="{{ __('Hrs') }}" value="{{ old('sunday_overtime_duration_hour', \App\Http\Controllers\HelperController::floatToHours($shift->sunday_overtime_start_time)) }}" > Hrs
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" name="sunday_overtime_duration_mins" class="col-md-3" placeholder="{{ __('Mins') }}" value="{{ old('sunday_overtime_duration_mins', \App\Http\Controllers\HelperController::floatToMinutes($shift->sunday_overtime_start_time)) }}" > Mins
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
<script>
$(document).ready(function(){

  function parentCheckChanged(){
    if($('input[name="sunday_check_parent"]:checkbox:checked').length > 0){
      $('.furtherOptions').fadeIn();
    }else{
      $('.furtherOptions').fadeOut();
    }
  }

  function checkChanged(){
    var checked = $("input[name='sunday_check']:checked").val();
    if(checked == "2"){
      $('.hiddenPart').show();
    }else{
      $('.hiddenPart').hide();
    }
  }

  $('input[name="sunday_check_parent"]').change(function(){

    parentCheckChanged();

  });
  $("input[name='sunday_check']").change(function(){
    checkChanged();
  });

  @if($shift->sunday_check>0 && $shift->sunday_check<3)

  $("#sunday_check_parent").prop("checked", true);
  parentCheckChanged();
  @if($shift->sunday_check == 1)
  $('#sunday_check_op1').prop("checked",true);
  @else
  $('#sunday_check_op2').prop("checked",true);
  @endif
  checkChanged();
  @endif

});
</script>
@endpush
