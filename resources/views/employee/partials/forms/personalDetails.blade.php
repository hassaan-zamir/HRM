<div class="card-body">

  <h6 class="heading-small text-muted mb-4">{{ __('Personal Details') }}</h6>
  <div class="pl-lg-4">

    <div class="form-group{{ $errors->has('nic') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-full-name">{{ __('NIC') }}</label>
      <input type="text" name="nic" id="input-nic" class="form-control form-control-alternative{{ $errors->has('nic') ? ' is-invalid' : '' }}" placeholder="{{ __('NIC') }}" value="{{ isset($personalDetails['nic'])? $personalDetails['nic']:old('nic') }}"  >

      @if ($errors->has('nic'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('nic') }}</strong>
      </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-full-name">{{ __('Gender') }}</label>
      <select name="gender" id="input-gender" class="form-control form-control-alternative{{ $errors->has('gender') ? 'is-invalid' : '' }}">
        <option value="Male" {{ isset($personalDetails['gender'])? ($personalDetails['gender'] == 'Male'?'selected':''):'' }}>Male</option>
        <option value="Female" {{ isset($personalDetails['gender'])? ($personalDetails['gender'] == 'Female'?'selected':''):'' }}>Female</option>
      </select>

      @if ($errors->has('gender'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('gender') }}</strong>
      </span>
      @endif
    </div>


    <div class="form-group{{ $errors->has('nationality') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-nationality">{{ __('Nationality') }}</label>
      <input type="text" name="nationality" id="input-nationality" class="form-control form-control-alternative{{ $errors->has('nationality') ? ' is-invalid' : '' }}" placeholder="{{ __('Nationality') }}" value="{{ isset($personalDetails['nationality'])? $personalDetails['nationality']:old('nationality') }}"  >

      @if ($errors->has('nationality'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('nationality') }}</strong>
      </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-dob">{{ __('dob') }}</label>
      <input type="date" name="dob" id="input-dob" class="form-control form-control-alternative{{ $errors->has('dob') ? ' is-invalid' : '' }}"  value="{{ isset($personalDetails['dob'])? $personalDetails['dob']->toDateString():old('dob') }}" >

      @if ($errors->has('dob'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('dob') }}</strong>
      </span>
      @endif
    </div>


    <div class="form-group{{ $errors->has('nic_expiry') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-nic_expiry">{{ __('NIC expiry') }}</label>
      <input type="date" name="nic_expiry" id="input-nic-expiry" class="form-control form-control-alternative{{ $errors->has('nic_expiry') ? ' is-invalid' : '' }}" placeholder="{{ __('NIC expiry') }}" value="{{ isset($personalDetails['nic_expiry'])? $personalDetails['nic_expiry']:old('nic_expiry') }}"  >

      @if ($errors->has('nic_expiry'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('nic_expiry') }}</strong>
      </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('marital_status') ? ' has-danger' : '' }}">
      <label class="form-control-label" for="input-marital_status">{{ __('Marital Status') }}</label>
      <select name="marital_status" id="input-marital-status" class="form-control form-control-alternative{{ $errors->has('marital_status') ? 'is-invalid' : '' }}">
        <option value="1" {{ isset($personalDetails['marital_status'])? ($personalDetails['marital_status'] == '1'?'selected':''):'' }}>Married</option>
        <option value="0" {{ isset($personalDetails['marital_status'])? ($personalDetails['marital_status'] == '0'?'selected':''):'' }}>Un-Married</option>
      </select>

      @if ($errors->has('marital_status'))
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('marital_status') }}</strong>
      </span>
      @endif
    </div>


    <input type="hidden" name="pic" value="test" />

  </div>
</div>
