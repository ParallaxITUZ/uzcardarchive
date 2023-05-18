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
<hr>
<h3>{{ __('common.permissions') }}</h3>
<div class="row">
    <div class="col-12 mb-2">
        <a class="btn btn-light check-all mr-2">{{ __('form.check_all') }}</a>
        <a class="btn btn-light uncheck-all">{{ __('form.uncheck_all') }}</a>
    </div>
    @foreach ($permissions as $permission)
        <div class="col-3 mb-2"><label><input type="checkbox" name="permissions[]" value="{{$permission->id}}" @if($item->hasPermission($permission->name)) checked @endif> {{$permission->name}}</label></div>
    @endforeach
</div>
<div class="mb-3 mt-3">
    <button type="submit" class="btn btn-success">{{ __('form.save') }}</button>
</div>
