<div class="card-body">

  @csrf

  <h6 class="heading-small text-muted mb-4">{{ __('Qualification Details') }}</h6>
  <div class="pl-lg-4 qualificationsDiv">

    @if(old('qualifications_title'))
      @foreach(old('qualifications_title') as $tag)
        @if($loop->index > 0)
        <hr><h6>New entry</h6>
        @else
        <div id="clone2">
        @endif

        <div class="form-group" >
          <label class="form-control-label" >{{ __('Qualification Title') }}</label>
          <input type="text" name="qualifications_title[]"  value="{{ old('qualifications_title')[$loop->index] }}" class="form-control form-control-alternative" placeholder="{{ __('Qualification Title') }}"  >
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Qualification Description') }}</label>
          <input type="text" name="qualifications_description[]" value="{{ old('qualifications_description')[$loop->index] }}"  class="form-control form-control-alternative" placeholder="{{ __('Description') }}"  >
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('From') }}</label>
          <input type="date" name="qualifications_start[]" value="{{ old('qualifications_start')[$loop->index] }}" class="form-control form-control-alternative" placeholder="{{ __('From') }}"  >
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Till') }}</label>
          <input type="date" name="qualifications_end[]" value="{{ old('qualifications_end')[$loop->index] }}" class="form-control form-control-alternative" placeholder="{{ __('End') }}"  >
        </div>
         @if($loop->index == 0) </div> @endif
      @endforeach
    @else

      <div id="clone2">
        <div class="form-group">
          <label class="form-control-label" >{{ __('Qualification Title') }}</label>
          <input type="text" name="qualifications_title[]"  class="form-control form-control-alternative" placeholder="{{ __('Qualification Title') }}"  >
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Qualification Description') }}</label>
          <input type="text" name="qualifications_description[]" class="form-control form-control-alternative" placeholder="{{ __('Description') }}"  >
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('From') }}</label>
          <input type="date" name="qualifications_start[]" class="form-control form-control-alternative" placeholder="{{ __('From') }}"  >
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Till') }}</label>
          <input type="date" name="qualifications_end[]" class="form-control form-control-alternative" placeholder="{{ __('End') }}"  >
        </div>
      </div>
    @endif





  </div>
  <button type="button" id="cloneQualificationsBtn" class="btn btn-primary" style="margin-left:25px;">Add More</button>
</div>
