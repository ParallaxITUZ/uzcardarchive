<x-app-layout>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <style>
        .icon {
            width: 1rem;
            height: 1rem;
            font-size: 1rem;
            color: black !important;
        }
    </style>
    <h2>{{ __('common.roles') }} <a href="{{ route('roles.create') }}" class="btn btn-primary float-end" type="button">{{ __('form.create_role') }}</a></h2>
    <div class="card mb-4">
        <div class="card-body">

            <table class="table table-sm">
                <tr>
                    <th>{{ __('common.name') }}</th>
                    <th>{{ __('common.display_name') }}</th>
                    <th>{{ __('common.description') }}</th>
                    <th class="text-end">{{ __('common.actions') }}</th>
                </tr>
                @foreach ($pagination as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->display_name}}</td>
                        <td>{{$item->description}}</td>
                        <td class="text-end">
                            <form action="{{ route('roles.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">

                                <a href="{{ route('roles.show', $item->id) }}" title="show">
                                    <i class="fas fa-eye text-success"></i>
                                </a>

                                <a href="{{ route('roles.edit', $item->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

            {!! $pagination->links() !!}

        </div>
    </div>
</x-app-layout>
