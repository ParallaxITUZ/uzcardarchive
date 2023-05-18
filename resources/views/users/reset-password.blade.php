<x-app-layout>
    <h2>{{ __('form.password_reset') }}: {{$item->name}} </h2>
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
            <form action="{{ route('users.set-password', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('form.new_password') }}</label>
                    <input class="form-control" id="password" type="password" placeholder="{{ __('form.new_password') }}" name="password" required>
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
