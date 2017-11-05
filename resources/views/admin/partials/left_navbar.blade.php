<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{action('Admin\AdminController@index')}}" class="site_title">
            {{--<i class="fa fa-gamepad"></i>--}}
            <span>
                <img src="{{asset('assets_client/img/logo.jpg')}}" alt="SHerna logo" style="height: 100%; padding-bottom: 10px">
            </span>
        </a>
    </div>

    <div class="clearfix"></div>
    <br/>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>Administration</h3>
            <ul class="nav side-menu">
                <li><a href="{{action('Admin\PagesController@index')}}"><i class="fa fa-fw fa-file-text-o"></i> Pages</a></li>
                <li><a href="{{action('Admin\ReservationsController@index')}}"><i class="fa fa-fw fa-address-card"></i> Reservations</a></li>
                @if(Auth::user()->isSuperAdmin())
                    <li><a><i class="fa fa-fw fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{action('Admin\UsersController@index')}}"><i class="fa fa-fw fa-users"></i> Users</a></li>
                            <li><a href="{{action('Admin\AdminsController@index')}}"><i class="fa fa-fw fa-user-secret"></i> Admins</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{action('Admin\UsersController@index')}}"><i class="fa fa-fw fa-users"></i> Users</a></li>
                @endif

                <li><a href="{{action('Admin\BadgesController@index')}}"><i class="fa fa-fw fa-id-badge"></i> Badges</a></li>
                <li><a href="{{action('Admin\LocationsController@index')}}"><i class="fa fa-fw fa-map-marker"></i> Locations</a></li>
                <li><a href="{{action('Admin\GamesController@index')}}"><i class="fa fa-fw fa-soccer-ball-o"></i> Games</a></li>
                <li><a href="{{action('Admin\ConsolesController@index')}}"><i class="fa fa-fw fa-gamepad"></i> Consoles</a></li>
                <li><a href="{{action('Admin\InventoryController@index')}}"><i class="fa fa-fw fa-cubes"></i> Inventory</a></li>
                <li><a href="{{action('Admin\ContestController@index')}}"><i class="fa fa-fw fa-sitemap"></i> Contests</a></li>

                @if(Auth::user()->isSuperAdmin())
                    <li><a href="{{action('Admin\SettingsController@index')}}"><i class="fa fa-fw fa-cogs"></i> Settings</a></li>
                @endif

                <li>
                    <a href="{{route('log-viewer::logs.list')}}"><i
                                class="fa fa-fw fa-history"></i> Logy</a>
                </li>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->
</div>