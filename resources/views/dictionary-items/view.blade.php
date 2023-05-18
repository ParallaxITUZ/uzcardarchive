<x-app-layout>
    <h2>
        {{ __('form.dictionary_item') }}: {{$item->title}}
        <form class="float-end" action="{{ route('dictionary-items.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">
            @method('DELETE')
            <a href="{{ route('dictionary-items.edit', $item->id) }}" class="btn btn-primary mr-2" type="button">{{ __('form.edit_dictionary_item') }}</a>
            <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this item?">{{ __('form.destroy_dictionary_item') }}</button>
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
                        <th>{{ __('common.title') }}</th>
                        <td>{{$item->title}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
