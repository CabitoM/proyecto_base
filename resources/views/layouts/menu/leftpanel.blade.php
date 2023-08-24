<!--Page Sidebar Start-->
<div class="page-sidebar custom-scrollbar">
    <div class="sidebar-user text-center">
       <div>
          <img style="width: 80px;height: 80px;" class="rounded-circle" src="{{getAvatar()}}" alt="#">
       </div>
       <h6 class="mt-3 f-12">{{ auth()->user()->name }}</h6>
    </div>
    <ul class="sidebar-menu">
       @include('layouts.menu.menu')
    </ul>   
    <div class="sidebar-widget text-center">
       <div class="sidebar-widget-top">
          <h6 class="mb-2 fs-14">Ayuda</h6>
          <i class="icon-bell"></i>
       </div>
       <div class="sidebar-widget-bottom p-20 m-20 digits">
          <p style="font-size: 10px;"> {{$info->telefono_soporte}}
             <br> {{$info->correo_soporte}}
             <br><a class="text-danger" href="{{$info->link_soporte}}" target="_blank">{{$info->txt_link_soporte}}</a>
          </p>
       </div>
    </div>
 </div>
 <input type="hidden" id="tog_menu" value="{{$info->menu_min}}">
 <!--Page Sidebar Ends-->
 