@forelse (traer_menu() as $key => $item)
    @if ($item['id_pertenece'] != 0)
        @break
    @endif
    @include('layouts.menu._menu_item', ['item' => $item,"vertical"=>$info->vertical])
@empty
@endforelse