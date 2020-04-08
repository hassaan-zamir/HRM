<div class="card-body">


  <h6 class="heading-small text-muted mb-4">{{ __('Salary Details') }}</h6>
  <div class="pl-lg-4">

    <div class="form-group">
      <label class="form-control-label" >{{ __('Basic Pay') }}</label>
      <input type="number" name="basic_pay" value="{{ isset($salaryDetails['salary'])? $salaryDetails['salary']:old('basic_pay') }}" class="form-control form-control-alternative" placeholder="{{ __('Basic Pay (PKR)') }}"  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >{{ __('Fuel Allowance') }}</label>
      <input type="number" name="fuel_allowance" value="{{ isset($salaryDetails['fuel_allowance'])? $salaryDetails['fuel_allowance']:old('fuel_allowance') }}" class="form-control form-control-alternative" placeholder="{{ __('Fuel Allowance (PKR)') }}"  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >{{ __('Mobile Allowance') }}</label>
      <input type="number" name="mobile_allowance" value="{{ isset($salaryDetails['mobile_allowance'])? $salaryDetails['mobile_allowance']:old('mobile_allowance') }}" class="form-control form-control-alternative" placeholder="{{ __('Mobile Allowance (PKR)') }}"  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >{{ __('Other Allowance') }}</label>
      <input type="number" name="other_allowance" value="{{ isset($salaryDetails['other_allowance'])? $salaryDetails['other_allowance']:old('other_allowance') }}" class="form-control form-control-alternative" placeholder="{{ __('Other Allowance (PKR)') }}"  >
    </div>

    <div class="form-group">
      <label class="form-control-label">Late-Early Deduction</label>
      <input type="checkbox" name="late_early_deductions" {{ isset($salaryDetails['late_early_deductions'])?($salaryDetails['late_early_deductions']?'checked':''):''}} />
    </div>

    <div class="form-group">
      <label class="form-control-label">Late Penalty</label>
      <input type="checkbox" name="late_penalty" {{ isset($salaryDetails['late_penalty'])?($salaryDetails['late_penalty']?'checked':''):''}}/>
    </div>

    <div class="form-group">
      <label class="form-control-label">Hourly Overtime Allow</label>
      <input type="checkbox" name="hourly_overtime_allow" {{ isset($salaryDetails['hourly_overtime_allow'])?($salaryDetails['hourly_overtime_allow']?'checked':''):''}}/>
    </div>



    <div class="form-group">
      <label class="form-control-label">Holiday Overtime Allow</label>
      <input type="checkbox"  name="holiday_overtime_allow" {{ isset($salaryDetails['holiday_overtime_allow'])?($salaryDetails['holiday_overtime_allow']?'checked':''):''}}/>
    </div>

    <div class="form-group">
      <label class="form-control-label" >Short Duty Hours</label>
      <input type="checkbox" name="short_duty_hours" {{ isset($salaryDetails['short_duty_hours'])?($salaryDetails['short_duty_hours']?'checked':''):''}}  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >Casual Leaves Allowed Per Month</label>
      <input type="number" name="monthly_casual_allow" value="{{ isset($salaryDetails['monthly_casual_allow'])? $salaryDetails['monthly_casual_allow']:old('monthly_casual_allow') }}" class="form-control form-control-alternative" placeholder="Monthly Casual Allowed"  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >Annual Leaves Allowed Per Month</label>
      <input type="number" name="monthly_annual_allow" value="{{ isset($salaryDetails['monthly_annual_allow'])? $salaryDetails['monthly_annual_allow']:old('monthly_annual_allow') }}" class="form-control form-control-alternative" placeholder="Monthly Annual Allowed"  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >Casual Leaves Allowed Per Year</label>
      <input type="number" name="total_casual_allow" value="{{ isset($salaryDetails['total_casual_allow'])? $salaryDetails['total_casual_allow']:old('	total_casual_allow') }}" class="form-control form-control-alternative" placeholder="Yearly Casual Allowed"  >
    </div>

    <div class="form-group">
      <label class="form-control-label" >Annual Leaves Allowed Per Year</label>
      <input type="number" name="total_annual_allow" value="{{ isset($salaryDetails['total_annual_allow'])? $salaryDetails['total_annual_allow']:old('total_annual_allow') }}" class="form-control form-control-alternative" placeholder="Yearly Annual Allowed"  >
    </div>



  </div>
</div>
