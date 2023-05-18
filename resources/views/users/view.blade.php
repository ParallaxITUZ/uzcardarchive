<x-app-layout>
    <h2>
        {{ __('common.user') }}: {{$item->name}}
        <form class="float-end" action="{{ route('users.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">
            @method('DELETE')
            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-primary mr-2" type="button">{{ __('form.edit_user') }}</a>
            <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this item?">{{ __('form.destroy_user') }}</button>
        </form>
    </h2>
    <div class="card mb-4">
        <div class="card-body">

            <table id="w0" class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{$item->id}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <td>{{$item->name}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('auth.Login') }}</th>
                        <td>{{$item->login}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.role') }}</th>
                        <td>{{$item->role}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('auth.status') }}</th>
                        <td>{{$item->status_name}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('auth.Password') }}</th>
                        <td>****</td>
                    </tr>
                    <tr>
                        <th>{{ __('auth.created_at') }}</th>
                        <td>{{$item->created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
