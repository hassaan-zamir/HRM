<div class="card-body">

  @csrf

  <h6 class="heading-small text-muted mb-4">{{ __('Past Work Experience Details') }}</h6>
  <div class="pl-lg-4 workExperienceDiv">

    @if(old('workexp_title'))
      @foreach(old('workexp_title') as $tag)
        @if($loop->index > 0)
        <hr><h6>New entry</h6>
        @else
          <div id="clone">
        @endif

        <div class="form-group">
          <label class="form-control-label" >{{ __('Work Title') }}</label>
          <input type="text" name="workexp_title[]"  value="{{ old('workexp_title')[$loop->index] }}" class="form-control form-control-alternative" placeholder="{{ __('Work Title') }}"  autofocus>
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Work Description') }}</label>
          <input type="text" name="workexp_description[]" value="{{ old('workexp_description')[$loop->index] }}"  class="form-control form-control-alternative" placeholder="{{ __('Work Experience') }}"  autofocus>
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('From') }}</label>
          <input type="date" name="workexp_start[]" value="{{ old('workexp_start')[$loop->index] }}" class="form-control form-control-alternative" placeholder="{{ __('From') }}"  autofocus>
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Till') }}</label>
          <input type="date" name="workexp_end[]" value="{{ old('workexp_end')[$loop->index] }}" class="form-control form-control-alternative" placeholder="{{ __('From') }}"  autofocus>
        </div>

        @if($loop->index == 0) </div> @endif
      @endforeach
    @else

      <div id="clone">
        <div class="form-group">
          <label class="form-control-label" >{{ __('Work Title') }}</label>
          <input type="text" name="workexp_title[]"  class="form-control form-control-alternative" placeholder="{{ __('Work Title') }}"  autofocus>
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Work Description') }}</label>
          <input type="text" name="workexp_description[]"  class="form-control form-control-alternative" placeholder="{{ __('Work Experience') }}"  autofocus>
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('From') }}</label>
          <input type="date" name="workexp_start[]" class="form-control form-control-alternative" placeholder="{{ __('From') }}"  autofocus>
        </div>

        <div class="form-group">
          <label class="form-control-label" >{{ __('Till') }}</label>
          <input type="date" name="workexp_end[]" class="form-control form-control-alternative" placeholder="{{ __('From') }}"  autofocus>
        </div>
      </div>
    @endif





  </div>
  <button type="button" id="cloneWorkExpBtn" class="btn btn-primary" style="margin-left:25px;">Add More</button>
</div>
