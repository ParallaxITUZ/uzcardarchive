<x-app-layout>
    <h2>{{ __('form.edit_role') }}: @if($item->display_name) {{$item->display_name}} @else {{$item->name}} @endif</h2>
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
            <form action="{{ route('roles.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('roles._form', [$item])
            </form>
        </div>
    </div>
</x-app-layout>
