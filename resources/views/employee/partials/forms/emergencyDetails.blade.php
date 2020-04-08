<div class="card-body">

        <h6 class="heading-small text-muted mb-4">{{ __('Emergency Details') }}</h6>
        <div class="pl-lg-4">

            <div class="form-group">
                <label class="form-control-label">{{ __('Contacts\'s Full Name') }}</label>
                <input type="text" name="emergency_full_name"  value="{{ isset($emergencyDetails['full_name'])? $emergencyDetails['full_name']:old('emergency_full_name') }}" class="form-control form-control-alternative" placeholder="{{ __('Contact\'s Name') }}" >
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ __('Contact Number') }}</label>
                <input type="text" name="emergency_contact"  value="{{ isset($emergencyDetails['contact'])? $emergencyDetails['contact']:old('emergency_contact') }}" class="form-control form-control-alternative" placeholder="{{ __('Contact Number') }}" >
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ __('Relation') }}</label>
                <input type="text" name="emergency_relation" value="{{ isset($emergencyDetails['relation'])? $emergencyDetails['relation']:old('emergency_relation') }}"  class="form-control form-control-alternative" placeholder="{{ __('Relation') }}" >
            </div>

        </div>
</div>
