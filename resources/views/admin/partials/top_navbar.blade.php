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
                    <li><a href="{{action('Client\ClientController@getLogout')}}"><i class="fa fa-sign-out pull-right"></i> Odhlásiť</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="badge bg-green">{{\App\Models\Reservation::activeReservations()->count()}}</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    @foreach(\App\Models\Reservation::activeReservations()->orderBy('day','asc')->orderBy('start','asc')->get() as $activeReservation)
                        <li>
                            <div class="text-center">
                                <a href="#">
                                    <strong>{{$activeReservation->owner->email}} {{date('d.m.Y H:i',strtotime($activeReservation->day.' '.$activeReservation->start))}}</strong>
                                </a>
                            </div>
                        </li>
                    @endforeach
                    <li>
                        <div class="text-center">
                            <a href="{{action('Admin\ReservationsController@index')}}">
                                <strong>Všetky registrácie</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>