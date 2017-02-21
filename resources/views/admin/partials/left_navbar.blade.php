<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{action('Admin\AdminController@index')}}" class="site_title">
            {{--<i class="fa fa-paw"></i>--}}
            <img src="{{asset('assets_admin/img/logo.png')}}" alt="SHerna logo">
            <span>SHerna</span>
        </a>
    </div>

    <div class="clearfix"></div>
    <br/>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>Administrácia</h3>
            <ul class="nav side-menu">
                <li><a href="{{action('Admin\AdminController@index')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
                <li><a href="{{action('Admin\ReservationsController@index')}}"><i class="fa fa-fw fa-address-card"></i> Reservations</a></li>
                <li><a href="{{action('Admin\UsersController@index')}}"><i class="fa fa-fw fa-users"></i> Users</a></li>
                <li><a href="{{action('Admin\BadgesController@index')}}"><i class="fa fa-fw fa-id-badge"></i> Badges</a></li>
                <li><a href="{{action('Admin\LocationsController@index')}}"><i class="fa fa-fw fa-map-marker"></i> Locations</a></li>
                <li><a href="{{action('Admin\GamesController@index')}}"><i class="fa fa-fw fa-soccer-ball-o"></i> Games</a></li>
                <li><a href="{{action('Admin\ConsolesController@index')}}"><i class="fa fa-fw fa-gamepad"></i> Consoles</a></li>
                <li><a href="{{action('Admin\InventoryController@index')}}"><i class="fa fa-fw fa-cubes"></i> Inventory</a></li>
                <li><a href="{{action('Admin\ContestController@index')}}"><i class="fa fa-fw fa-sitemap"></i> Contests</a></li>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->
</div>