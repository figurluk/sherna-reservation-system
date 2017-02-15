<?php
$controller = str_replace('App\\Http\\Controllers\\', '', substr(Route::currentRouteAction(), 0, (strpos(Route::currentRouteAction(), '@'))));
$controllerMethod = str_replace('App\\Http\\Controllers\\', '', substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1)));
?>

<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{action('Admin\AdminController@index')}}" class="site_title">
            {{--<i class="fa fa-paw"></i>--}}
            <img src="{{asset('assets_admin/img/logo.png')}}" alt="SHerna logo">
            <span>SHerna</span>
        </a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
        <div class="profile_info">
            <span>Vítajte,</span>
{{--            <h2>{{Auth::user()->name}} {{Auth::user()->surname}}</h2>--}}
            Admin adminko
            <br>
        </div>
    </div>
    <!-- /menu profile quick info -->

    <br/>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>Administrácia</h3>
            <ul class="nav side-menu">
                <li><a href="{{action('Admin\AdminController@index')}}"><i class="fa fa-fw fa-home"></i> Domov</a></li>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->
</div>