<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.plugins_css')
</head>
<body>
    <div class="page-wrapper">
        @include("layouts.header")
        @if ($info->vertical=="Y")
            @include("layouts.menu.toppanel")
        @endif
        <div class="page-body-wrapper">
            @if ($info->vertical!="Y")
                 @include("layouts.menu.leftpanel")
            @endif
            <div class="page-body @if ($info->vertical=="Y") vertical-menu-mt @else  @endif pb-5">
                @yield("content")
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <div class="col-sm-12 divCargando" id="divCargando"> </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div id="modalResultado" class="modal-dialog" role="document">
        </div>
    </div>
    @include('layouts.plugins_js')
</body>
</html>
