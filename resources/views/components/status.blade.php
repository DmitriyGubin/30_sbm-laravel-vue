<div class="var_box hide_box mark_class">
@foreach ($roles as $item)
@continue($item['id'] == 1)
    <div data-id="{{ $item['id'] }}" class="var_item mark_class">
        <span class="name mark_class">{{ $item['name'] }}</span>
    </div>
@endforeach
</div>