<x-app-layout>
    <h2>
        {{ __('common.permission') }}: @if($permission->display_name) {{$permission->display_name}} @else {{$permission->name}} @endif
        <form class="float-end" action="{{ route('permissions.destroy', $permission) }}" method="POST" data-confirm="Are you sure that you want to delete this?">
            @method('DELETE')
            <a href="{{ route('permissions.edit', $permission, app()->getLocale()) }}" class="btn btn-primary mr-2" type="button">{{ __('form.edit_permission') }}</a>
            <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this item?">{{ __('form.destroy_permission') }}</button>
        </form>
    </h2>
    <div class="card mb-4">
        <div class="card-body">

            <table id="w0" class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{$permission->id}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <td>{{$permission->name}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.display_name') }}</th>
                        <td>{{$permission->display_name}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.description') }}</th>
                        <td>{{$permission->description}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
