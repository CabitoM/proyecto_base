@if ($item['submenu'] == [])
    <li>
        <a href="{{ !empty($item['ruta']) ? route($item['ruta']) :"#" }}">
            <i class="{{ $item['icono']}} {{ $item['color']}}"></i>
            <span>{{ $item['titulo'] }}</span> 
            @if ($vertical=="N")
                <i class="fa fa-angle-right pull-right"></i>
            @endif
        </a>
    </li>
@else
@php
    //{{($menu_selected==$item['titulo']?"active":"")}}
@endphp
    <li class="">
        <a href="{{ !empty($item['ruta']) ? route($item['ruta']) :"#" }}" class="{{(($vertical=="N")?'sidebar-header':'')}}">
            <i class="{{ $item['icono']}} {{ $item['color']}}"></i>
            <span>{{ $item['titulo'] }}</span> 
            @if ($vertical=="N")
                <i class="fa fa-angle-right pull-right"></i>
            @endif
        </a>
        <ul class="{{(($vertical=="N")?'sidebar-submenu':'')}}">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li>
                        <a href="{{ !empty($submenu['ruta']) ? route($submenu['ruta']) :"#" }}">
                            <i class="{{ $submenu['icono']}} {{ $submenu['color']}}"></i>
                            <span>{{ $submenu['titulo'] }}</span> 
                            @if ($vertical=="N")
                                <i class="fa fa-angle-right pull-right"></i>
                            @endif
                        </a>
                    </li>
                @else
                    @include('layouts.menu._menu_item', [ 'item' => $submenu,"vertical"=>$vertical ])
                @endif
            @endforeach
        </ul>
    </li>
@endif