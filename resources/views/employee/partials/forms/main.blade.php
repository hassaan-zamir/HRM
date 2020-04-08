<div class="card-body">

  @csrf

  <h6 class="heading-small text-muted mb-4">{{ __('Employee information') }}</h6>
  <div class="pl-lg-4">

    <div class="form-group{{ $errors->has('machine_id') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-full-name">{{ __('Employee Machine Id') }}</label>
      <input type="number" name="machine_id" id="input-machine_id" class="form-control form-control-alternative{{ $errors->has('machine_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Machine Id') }}" value="{{ isset($employee) ? $employee->machine_id:old('machine_id') }}" required autofocus>

      @if ($errors->has('machine_id'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('machine_id') }}</strong>
      </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('full_name') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-full-name">{{ __('Full Name') }}</label>
      <input type="text" name="full_name" id="input-full-name" class="form-control form-control-alternative{{ $errors->has('full_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Full Name') }}" value="{{ isset($employee) ? $employee->full_name:old('full_name') }}" required autofocus>

      @if ($errors->has('full_name'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('full_name') }}</strong>
      </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('designation') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-designation">{{ __('Designation') }}</label>
        <select name="designation" id="input-designation" class="form-control form-control-alternative{{ $errors->has('designation') ? 'is-invalid' : '' }}" required="required" placeholder="Designation">
          @foreach($designations as $designation)
           <option value="{{ $designation->title }}" {{ isset($employee) ? ($employee->designation == $designation->title ? 'selected' : ''): ''}} >{{ $designation->title }}</option>
          @endforeach
        </select>
        @if ($errors->has('designation'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('designation') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('department') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-department">{{ __('Department') }}</label>
        <select name="department" id="input-department" class="form-control form-control-alternative{{ $errors->has('department') ? ' is-invalid' : '' }}" required="required" placeholder"{{ __('Department') }}" >
        @foreach($departments as $department)
          <option value="{{ $department->id }}" {{ isset($employee) ? ($employee->department == $department->id ? 'selected' : ''): ''}}>{{ $department->name }}</option>
        @endforeach
        </select>


        @if ($errors->has('department'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('department') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('join_date') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-join_date">{{ __('Join Date') }}</label>
        <input type="date" name="join_date" id="input-join_date" class="form-control form-control-alternative{{ $errors->has('join_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Join Date') }}" value="{{ isset($employee) ? $employee->join_date->toDateString():old('join_date') }}" required >

        @if ($errors->has('join_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('join_date') }}</strong>
            </span>
        @endif
    </div>






  </div>
</div>
