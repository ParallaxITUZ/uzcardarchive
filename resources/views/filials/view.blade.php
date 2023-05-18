<x-app-layout>
    <h2>
        {{ __('common.role') }}: @if($item->display_name) {{$item->display_name}} @else {{$item->name}} @endif
        <form class="float-end" action="{{ route('roles.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">
            @method('DELETE')
            <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-primary mr-2" type="button">{{ __('form.edit_role') }}</a>
            <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this item?">{{ __('form.destroy_role') }}</button>
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
                        <th>{{ __('common.display_name') }}</th>
                        <td>{{$item->display_name}}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.description') }}</th>
                        <td>{{$item->description}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
