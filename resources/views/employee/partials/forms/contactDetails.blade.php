<div class="card-body">

        <h6 class="heading-small text-muted mb-4">{{ __('Contact Details') }}</h6>
        <div class="pl-lg-4">

            <div class="form-group">
                <label class="form-control-label">{{ __('Mobile No') }}</label>
                <input type="text" name="contact_mobile"  class="form-control form-control-alternative" placeholder="{{ __('Mobile') }}" value="{{ isset($contactDetails['mobile'])? $contactDetails['mobile']:old('contact_mobile') }}" >
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ __('Mobile #2') }}</label>
                <input type="text" name="contact_mobile2"  class="form-control form-control-alternative" placeholder="{{ __('Mobile 2') }}" value="{{ isset($contactDetails['mobile2'])? $contactDetails['mobile2']:old('contact_mobile2') }}" >
            </div>

            <div class="form-group">
                <label class="form-control-label">{{ __('Address') }}</label>
                <input type="text" name="contact_address"  class="form-control form-control-alternative" placeholder="{{ __('Address') }}" value="{{ isset($contactDetails['address'])? $contactDetails['address']:old('contact_address') }}" >
            </div>

        </div>
</div>
