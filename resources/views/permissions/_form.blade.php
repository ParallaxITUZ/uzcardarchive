<div class="mb-3">
    <label class="form-label" for="name">{{ __('common.name') }}</label>
    <input class="form-control" id="name" type="text" placeholder="{{ __('common.name') }}" name="name" value="{{$item->name}}">
</div>
<div class="mb-3">
    <label class="form-label" for="display_name">{{ __('common.display_name') }}</label>
    <input class="form-control" id="display_name" type="text" placeholder="{{ __('common.display_name') }}" name="display_name" value="{{$item->display_name}}">
</div>
<div class="mb-3">
    <label class="form-label" for="description">{{ __('common.description') }}</label>
    <input class="form-control" id="description" type="text" placeholder="{{ __('common.description') }}" name="description" value="{{$item->description}}">
</div>
<div class="mb-3">
    <button type="submit" class="btn btn-success">{{ __('form.save') }}</button>
</div>
