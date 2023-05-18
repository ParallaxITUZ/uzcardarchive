<x-app-layout>
    <h2>
        {{ __('common.policy') }}: {{$item->name}}
        <form class="float-end" action="{{ route('policies.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">
            @method('DELETE')
            <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-primary mr-2" type="button">{{ __('form.edit_policy') }}</a>
            <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this item?">{{ __('form.destroy_policy') }}</button>
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
                        <th>{{ __('common.company') }}</th>
                        <td>{{$item->company->name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
