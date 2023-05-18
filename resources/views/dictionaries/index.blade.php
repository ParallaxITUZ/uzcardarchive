<x-app-layout>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <h2>{{ __('common.dictionaries') }} <a href="{{ route('dictionaries.create') }}" class="btn btn-primary float-end" type="button">{{ __('form.create_dictionary') }}</a></h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="accordion mb-3" id="dictionaries">
                @forelse ($pagination as $item)
                    <div class="accordion-item">
                        <div class="accordion-header" id="dictionary-heading-{{$item->id}}">
                            <div class="accordion-button collapsed" type="button" style="display: block" data-coreui-toggle="collapse" data-coreui-target="#dictionary-{{$item->id}}" aria-expanded="true" aria-controls="dictionary-{{$item->id}}">
                                {{$item->display_name}}
                                <div class="float-end">
                                    <a href="{{ route('dictionary-items.create', [1, $item->id]) }}"><i class="fas fa-plus"></i></a>
                                    <a href="{{ route('dictionaries.edit', $item->id) }}"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dictionaries.destroy', $item->id) }}" method="POST" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"><i class="fas fa-trash text-danger"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="dictionary-{{$item->id}}" class="accordion-collapse collapse" aria-labelledby="dictionary-heading-{{$item->id}}" data-coreui-parent="#dictionaries">
                            <div class="accordion-body">
                                @forelse($item->items as $items)
                                    @if($items->parent_id == null)
                                    <x-dictionary-item :dictionary="$items" dictionary-id="{{$item->id}}" depth="1" />
                                    @endif
                                @empty
                                    <p>{{ __('common.empty') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <h2 @class('text-center')>{{ __('common.empty') }}</h2>
                @endforelse
            </div>

{{--            <div class="dictionaries mb-3">--}}
{{--                @forelse ($pagination as $item)--}}
{{--                    <div class="dictionary-item">--}}
{{--                        <div class="dictionary-header mb-1">--}}
{{--                            <span @class('h3')>{{$item->title}}</span>--}}
{{--                            <div class="float-end">--}}
{{--                                <a href="{{ route('dictionary-items.create', [$dictionary->id, $item->id]) }}"><i class="fas fa-plus"></i></a>--}}
{{--                                <a href="{{ route('dictionaries.edit', $item->id) }}"><i class="fas fa-edit"></i></a>--}}
{{--                                <form action="{{ route('dictionaries.destroy', $item->id) }}" method="POST" style="display: inline-block">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit"><i class="fas fa-trash text-danger"></i></button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="dictionary-body">--}}
{{--                            @forelse($item->items as $items)--}}
{{--                                @if($items->parent_id == null)--}}
{{--                                    <x-dictionary-item :dictionary="$items" dictionary-id="{{$item->id}}" depth="1"/>--}}
{{--                                @endif--}}
{{--                            @empty--}}
{{--                                <p>{{ __('common.empty') }}</p>--}}
{{--                            @endforelse--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @empty--}}
{{--                    <h2 @class('text-center')>{{ __('common.empty') }}</h2>--}}
{{--                @endforelse--}}
{{--            </div>--}}

{{--            @foreach ($pagination as $dictionary)--}}
{{--            <div>--}}
{{--                <span @class('h3')>{{ $dictionary->title }}</span>--}}
{{--                <div class="float-end">--}}
{{--                    <a href="{{ route('dictionary-items.create', $dictionary->id) }}"><i class="fas fa-plus"></i></a>--}}
{{--                    <a href="{{ route('dictionaries.edit', $dictionary->id) }}"><i class="fas fa-edit"></i></a>--}}
{{--                    <form action="{{ route('dictionaries.destroy', $dictionary->id) }}" method="POST" style="display: inline-block">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit"><i class="fas fa-trash text-danger"></i></button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <table class="table table-sm">--}}
{{--                <tr>--}}
{{--                    <th>{{ __('common.display_name') }}</th>--}}
{{--                    <th>{{ __('common.description') }}</th>--}}
{{--                    <th>{{ __('common.parent') }}</th>--}}
{{--                    <th class="text-end">{{ __('common.actions') }}</th>--}}
{{--                </tr>--}}
{{--                @foreach ($dictionary->items as $item)--}}
{{--                    <tr>--}}
{{--                        <td>{{$item->title}}</td>--}}
{{--                        <td>{{$item->description}}</td>--}}
{{--                        @isset($item->parentItem)--}}
{{--                        <td>{{$item->parentItem->title}}</td>--}}
{{--                        @else--}}
{{--                        <td></td>--}}
{{--                        @endisset--}}
{{--                        <td class="text-end">--}}
{{--                            <form action="{{ route('dictionary-items.destroy', $item->id) }}" method="POST" data-confirm="Are you sure that you want to delete this?">--}}

{{--                                <a href="{{ route('dictionary-items.create', [$dictionary->id, $item->id]) }}" title="create">--}}
{{--                                    <i class="fas fa-plus text-success"></i>--}}
{{--                                </a>--}}

{{--                                <a href="{{ route('dictionary-items.edit', [$dictionary->id]) }}">--}}
{{--                                    <i class="fas fa-edit"></i>--}}
{{--                                </a>--}}

{{--                                @csrf--}}
{{--                                @method('DELETE')--}}

{{--                                <button type="submit" title="delete" style="border: none; background-color:transparent;">--}}
{{--                                    <i class="fas fa-trash text-danger"></i>--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--            </table>--}}
{{--            @endforeach--}}

            {!! $pagination->links() !!}
        </div>
    </div>
</x-app-layout>
