<x-app-layout>
    <h2>{{ __('form.edit_permission') }}: @if($item->display_name) {{$item->display_name}} @else {{$item->name}} @endif</h2>
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
            <form action="{{ route('permissions.update', $item) }}" method="POST">
                @csrf
                @method('PUT')
                @include('permissions._form', [$item])
            </form>
        </div>
    </div>
</x-app-layout>
