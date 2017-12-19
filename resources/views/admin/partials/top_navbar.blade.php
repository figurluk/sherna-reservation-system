<div class="nav_menu">
    <nav class="" role="navigation">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{Auth::user()->name}} {{Auth::user()->surname}}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{action('Client\ClientController@getLogout')}}"><i class="fa fa-sign-out pull-right"></i> Log out</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="badge bg-green">{{\App\Models\Reservation::futureReservations()->count()}}</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    @foreach(\App\Models\Reservation::futureReservations()->orderBy('start','asc')->get() as $futureReservation)
                        <li>
                            <div class="text-center">
                                <a href="#">
                                    <strong>{{$futureReservation->ownerEmail()}} {{date('d.m.Y H:i',strtotime($futureReservation->start))}}</strong>
                                </a>
                            </div>
                        </li>
                    @endforeach
                    <li>
                        <div class="text-center">
                            <a href="{{action('Admin\ReservationsController@index')}}">
                                <strong>All reservations</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{action('Client\ClientController@index')}}"><i class="fa fa-globe"></i></a>
            </li>
        </ul>
    </nav>
</div>