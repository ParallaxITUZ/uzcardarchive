<x-app-layout>
    <h2>{{ __('form.create_policy') }}</h2>
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
            <form action="{{ route('policies.store') }}" method="POST">
                @csrf
                @include('policies._form', [$item])
            </form>
        </div>
    </div>
</x-app-layout>
