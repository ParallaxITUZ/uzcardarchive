<div class="mb-3">
    <label class="form-label" for="name">{{ __('common.name') }}</label>
    <input class="form-control" id="name" type="text" placeholder="{{ __('common.name') }}" name="name" value="{{$item->name}}">
</div>
<div class="mb-3">
    <label class="form-label" for="region">{{ __('common.region') }}</label>
    <select name="region" id="region" class="form-control">
        @foreach ($regions as $region)
            <option value="{{ $region->id }}">{{ $region->title }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label" for="inn">{{ __('common.inn') }}</label>
    <input class="form-control" id="inn" type="text" placeholder="{{ __('common.inn') }}" name="inn" value="{{$item->inn}}">
</div>
<div class="mb-3">
    <label class="form-label" for="account">{{ __('common.account') }}</label>
    <input class="form-control" id="account" type="text" placeholder="{{ __('common.account') }}" name="account" value="{{$item->account}}">
</div>
<div class="mb-3">
    <label class="form-label" for="address">{{ __('common.address') }}</label>
    <input class="form-control" id="address" type="text" placeholder="{{ __('common.address') }}" name="address" value="{{$item->address}}">
</div>
<div class="mb-3">
    <label class="form-label" for="director_fio">{{ __('common.director_fio') }}</label>
    <input class="form-control" id="director_fio" type="text" placeholder="{{ __('common.director_fio') }}" name="director_fio" value="{{$item->director_fio}}">
</div>
<div class="mb-3">
    <label class="form-label" for="director_tel">{{ __('common.director_tel') }}</label>
    <input class="form-control" id="director_tel" type="text" placeholder="{{ __('common.director_tel') }}" name="director_tel" value="{{$item->director_tel}}">
</div>
<hr>
@include('components.org_str_user_form', [$item])
<div class="mb-3 mt-3">
    <button type="submit" class="btn btn-success">{{ __('form.save') }}</button>
</div>
