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
    <h2>{{ __('common.centres') }} <a href="{{ route('centres.create') }}" class="btn btn-primary float-end" type="button">{{ __('form.create_centre') }}</a></h2>
    <div class="card mb-4">
        <div class="card-body">

            <table class="table table-sm">
                <tr>
                    <th>{{ __('common.name') }}</th>
                    <th>{{ __('common.region') }}</th>
                    <th>{{ __('common.parent_id') }}</th>
{{--                    <th>{{ __('common.company_number') }}</th>--}}
{{--                    <th>{{ __('common.filial_number') }}</th>--}}
{{--                    <th>{{ __('common.centre_department_number') }}</th>--}}
                    <th>{{ __('common.inn') }}</th>
                    <th>{{ __('common.account') }}</th>
                    <th>{{ __('common.address') }}</th>
                    <th>{{ __('common.director_fio') }}</th>
                    <th>{{ __('common.director_tel') }}</th>
                    <th class="text-end">{{ __('common.actions') }}</th>
                </tr>
                @foreach ($pagination as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->region->title}}</td>
                        <td>{{$item->parent->name}}</td>
{{--                        <td>{{$item->company_number}}</td>--}}
{{--                        <td>{{$item->filial_number}}</td>--}}
{{--                        <td>{{$item->centre_department_number}}</td>--}}
                        <td>{{$item->inn}}</td>
                        <td>{{$item->account}}</td>
                        <td>{{$item->address}}</td>
                        <td>{{$item->director_fio}}</td>
                        <td>{{$item->director_tel}}</td>
                        <td class="text-end">
                            <form action="{{ route('centres.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">

                                <a href="{{ route('centres.show', $item->id) }}" title="show">
                                    <i class="fas fa-eye text-success"></i>
                                </a>

                                <a href="{{ route('centres.edit', $item->id) }}">
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
