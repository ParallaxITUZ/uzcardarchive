<x-app-layout>
    <h2>{{ __('form.create_user') }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('form.error') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('common.name') }}</label>
                    <input class="form-control" id="name" type="text" placeholder="{{ __('common.name') }}" name="name" value="{{$item->name}}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="role">{{ __('common.role') }}</label>
                    <select class="form-control" id="role" type="text" name="role" required>
                        <option value="">{{ __('form.choose_role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
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
                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-success">{{ __('form.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
