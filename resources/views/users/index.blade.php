<x-app-layout>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <h2>{{ __('common.users') }} <a href="{{ route('users.create') }}" class="btn btn-primary float-end" type="button">{{ __('form.create_user') }}</a></h2>
    <div class="card mb-4">
        <div class="card-body">
            @if(count($pagination) == 0)
                <h2 class="text-center">{{ __('common.no_users') }}</h2>
            @else
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('common.name') }}</th>
                            <th>{{ __('auth.Login') }}</th>
                            <th>{{ __('common.role') }}</th>
                            <th>{{ __('auth.status') }}</th>
{{--                            <th>{{ __('auth.Password') }}</th>--}}
                            <th>{{ __('auth.created_at') }}</th>
                            <th class="text-end">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pagination as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->login}}</td>
                            <td>{{$item->role }}</td>
                            <td>{{$item->status_name}}</td>
{{--                            <td>****</td>--}}
                            <td>{{$item->created_at}}</td>
                            <td class="text-end">
                                <form action="{{ route('users.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">

                                    <a href="{{ route('users.reset-password', $item->id) }}" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </a>

                                    <a href="{{ route('users.show', $item->id) }}" title="Show user">
                                        <i class="fas fa-eye text-success fa-lg"></i>
                                    </a>

                                    <a href="{{ route('users.edit', $item->id) }}" title="Update user">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                        <i class="fas fa-trash fa-lg text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $pagination->links() !!}
            @endif

        </div>
    </div>
</x-app-layout>
