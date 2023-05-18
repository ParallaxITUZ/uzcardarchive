<x-app-layout>
    <h2>{{ __('form.edit_dictionary_item') }}: {{ $item->title }} </h2>
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
            <form action="{{ route('dictionary-items.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('dictionary-items._form')
            </form>
        </div>
    </div>
</x-app-layout>
