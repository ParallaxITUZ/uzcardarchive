<h3>{{ __('common.user') }}</h3>
<div class="mb-3">
    <label class="form-label" for="login">{{ __('auth.Login') }}</label>
    <input class="form-control" id="login" type="text" placeholder="{{ __('auth.Login') }}" name="login" value="{{$item->login}}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="password">{{ __('auth.Password') }}</label>
    <input class="form-control" id="password" type="password" placeholder="{{ __('auth.Password') }}" name="password" required>
</div>
<div class="mb-3">
    <label class="form-label" for="password_confirmation">{{ __('auth.password_confirmation') }}</label>
    <input class="form-control" id="password_confirmation" type="password" placeholder="{{ __('auth.password_confirmation') }}" name="password_confirmation" required>
</div>
<hr>
