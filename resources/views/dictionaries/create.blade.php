<x-app-layout>
    <h2>{{ __('form.create_dictionary') }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('common.name') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dictionaries.store') }}" method="POST">
                @csrf
                @include('dictionaries._form')
            </form>
        </div>
    </div>
</x-app-layout>
