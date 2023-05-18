<div class="mb-3">
    <label class="form-label" for="title">{{ __('common.title') }}</label>
    <input class="form-control" id="title" type="text" placeholder="{{ __('common.title') }}" name="title" value="{{$item->title}}">
</div>
<div class="mb-3">
    <label class="form-label" for="description">{{ __('common.description') }}</label>
    <textarea class="form-control" id="description" placeholder="{{ __('common.description') }}" name="description" rows="3"></textarea>
</div>
<hr>
<div class="mb-3 mt-3">
    <button type="submit" class="btn btn-success">{{ __('form.save') }}</button>
</div>
