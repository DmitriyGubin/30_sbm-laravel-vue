@foreach ($menu as $item)
@if(!$chek_auth || (!in_array($item['url'], $no_cab_urls)) )
    @continue(in_array($item['url'], $cab_urls) && !$chek_auth)
    @continue(in_array($item['url'], $cab_urls) && $chek_auth && $cab_urls[$role_id] != $item['url'])
    <li>
        <a class="{{ $cur_url == $item['url'] ? 'active' : null }}" href="{{ $item['url'] }}">{{ $item['name'] }}</a>
    </li>
@endif
@endforeach


                