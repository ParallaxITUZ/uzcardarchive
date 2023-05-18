<h3>{{ __('common.contract') }}</h3>
<div class="mb-3">
    <label class="form-label" for="signer">{{ __('common.signer') }}</label>
    <input class="form-control" id="signer" type="text" placeholder="{{ __('common.signer') }}" name="signer" value="{{$item->signer}}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="default_commission">{{ __('common.default_commission') }}</label>
    <input class="form-control" id="default_commission" type="text" placeholder="{{ __('common.default_commission') }}" name="default_commission" value="{{$item->default_commission}}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="number">{{ __('common.number') }}</label>
    <input class="form-control" id="number" type="text" placeholder="{{ __('common.number') }}" name="number" required>
</div>
<div class="mb-3">
    <label class="form-label" for="date_from">{{ __('form.date_from') }}</label>
    <input class="form-control" id="date_from" type="date" name="date_from" required>
</div>
<div class="mb-3">
    <label class="form-label" for="date_to">{{ __('form.date_to') }}</label>
    <input class="form-control" id="date_to" type="date" name="date_to" required>
</div>
<div class="mb-3">
    <label class="form-label" for="file">{{ __('form.file') }}</label>
    <input class="form-control" id="file" type="file" name="file" required>
</div>
<hr>
