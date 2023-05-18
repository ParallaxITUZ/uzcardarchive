<div class="mb-3">
    <label class="form-label" for="name">{{ __('common.name') }}</label>
    <input class="form-control" id="name" type="text" placeholder="{{ __('common.name') }}" name="name" value="{{$item->name}}">
</div>
<hr>
<div class="mb-3 mt-3">
    <button type="submit" class="btn btn-success">{{ __('form.save') }}</button>
</div>
