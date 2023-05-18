<x-app-layout>
    <h2>{{ __('form.create_dictionary_item') }}</h2>
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
            <form action="{{ route('dictionary-items.store', [$dictionary_id, $parent_id]) }}" method="POST">
                @csrf
                @include('dictionary-items._form')
            </form>
        </div>
    </div>
</x-app-layout>
