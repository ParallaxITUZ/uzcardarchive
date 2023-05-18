<div class="accordion" id="dictionary-item-parent-{{$dictionary->id}}">
    <div class="accordion-item">

        @if(count($dictionary->items) > 0)
        <div class="accordion-header" id="dictionary-item-heading-{{$dictionary->id}}">
            <div class="accordion-button collapsed" type="button" style="display: block" data-coreui-toggle="collapse" data-coreui-target="#dictionary-item-{{$dictionary->id}}" aria-expanded="true" aria-controls="dictionary-item-{{$dictionary->id}}">
                {{$dictionary->title}}
                <div class="float-end">
                    <a href="{{ route('dictionary-items.create', [$dictionary_id, $dictionary->id]) }}"><i class="fas fa-plus"></i></a>
                    <a href="{{ route('dictionary-items.edit', [$dictionary->id]) }}"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('dictionaries.destroy', $dictionary->id) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fas fa-trash text-danger"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div id="dictionary-item-{{$dictionary->id}}" class="accordion-collapse collapse" aria-labelledby="dictionary-item-heading-{{$dictionary->id}}" data-coreui-parent="#dictionary-item-parent-{{ $dictionary->id }}">
            <div class="accordion-body">
                @forelse($dictionary->items as $items)
                    @if($items->parent_id == $dictionary->id)
                        <x-dictionary-item :dictionary="$items" dictionary-id="{{$dictionary_id}}"  depth="1" />
                    @endif
                @empty
                    <p>{{ __('common.empty') }}</p>
                @endforelse
            </div>
        </div>
        @else
        <div class="accordion-header">
            <div class="accordion-button collapsed" type="button" style="display: block">
                {{$dictionary->title}}
                <div class="float-end">
                    <a href="{{ route('dictionary-items.create', [$dictionary_id, $dictionary->id]) }}"><i class="fas fa-plus"></i></a>
                    <a href="{{ route('dictionary-items.edit', $dictionary->id) }}"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('dictionary-items.destroy', $dictionary->id) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fas fa-trash text-danger"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>


{{--<div class="dictionary-items mb-1">--}}
{{--    <div class="dictionary-items-item">--}}

{{--        @if(count($dictionary->items) > 0)--}}
{{--        <div class="dictionary-item-header">--}}
{{--            @for($i = 1; $i <= $depth; $i++)--}}
{{--                <i class="fas fa-minus"></i>--}}
{{--            @endfor--}}
{{--            <span @class('h4')>{{$dictionary->title}}</span>--}}
{{--            <div class="float-end">--}}
{{--                <a href="{{ route('dictionary-items.create', [$dictionary_id, $dictionary->id]) }}"><i class="fas fa-plus"></i></a>--}}
{{--                <a href="{{ route('dictionary-items.edit', [$dictionary->id]) }}"><i class="fas fa-edit"></i></a>--}}
{{--                <form action="{{ route('dictionary-items.destroy', $dictionary->id) }}" method="POST" style="display: inline-block">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button type="submit"><i class="fas fa-trash text-danger"></i></button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <hr>--}}
{{--        <div class="dictionary-item-body">--}}
{{--            @forelse($dictionary->items as $items)--}}
{{--                @if($items->parent_id == $dictionary->id)--}}
{{--                    <x-dictionary-item :dictionary="$items" dictionary-id="{{$dictionary_id}}" depth="{{$depth+1}}"/>--}}
{{--                @endif--}}
{{--            @empty--}}
{{--                <p>{{ __('common.empty') }}</p>--}}
{{--            @endforelse--}}
{{--        </div>--}}
{{--        @else--}}
{{--        <div class="dictionary-item-header">--}}
{{--            @for($i = 1; $i <= $depth; $i++)--}}
{{--                <i class="fas fa-minus"></i>--}}
{{--            @endfor--}}
{{--            <span @class('h4')>{{$dictionary->title}}</span>--}}
{{--            <div class="float-end">--}}
{{--                <a href="{{ route('dictionary-items.create', [$dictionary_id, $dictionary->id]) }}"><i class="fas fa-plus"></i></a>--}}
{{--                <a href="{{ route('dictionary-items.edit', $dictionary->id) }}"><i class="fas fa-edit"></i></a>--}}
{{--                <form action="{{ route('dictionary-items.destroy', $dictionary->id) }}" method="POST" style="display: inline-block">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button type="submit"><i class="fas fa-trash text-danger"></i></button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <hr>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}
