<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{action('Client\ClientController@index')}}">
                <img alt="SHerna logo" src="{{asset('assets_client/img/logo.png')}}" style="height: 100%">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{trans('general.navbar.about-project')}}</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{action('Client\ClientController@show','o-sherne')}}">{{getName('o-sherne')}}</a></li>
                        <li><a href="{{action('Client\ClientController@show','clenove')}}">{{getName('clenove')}}</a></li>
                        <li><a href="{{action('Client\ClientController@show','vyrocni-spravy')}}">{{getName('vyrocni-spravy')}}</a></li>
                    </ul>
                </li>
                <li><a href="{{action('Client\ClientController@show','rezervace')}}">{{getName('rezervace')}}</a></li>
                <li><a href="{{action('Client\ClientController@show','turnaje')}}">{{getName('turnaje')}}</a></li>
                <li><a href="{{action('Client\ClientController@show','vybaveni')}}">{{getName('vybaveni')}}</a></li>
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}} {{Auth::user()->surname}}</a>
                        <ul class="dropdown-menu">
                            <li><a href="#contact">Moje rezervace</a></li>
                            <li><a href="{{action('Client\ClientController@getLogout')}}">Odhlaseni</a></li>


                            @if(Auth::user()->admin())
                                <li class="divider" role="separator"></li>
                                <li><a href="{{action('Admin\AdminController@index')}}">Administrace</a></li>
                            @endif
                        </ul>
                    </li>
                @else
                    <li><a href="{{action('Client\ClientController@getAuthorize')}}">{{trans('general.navbar.login')}}</a></li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-{{Session::get('lang') =='en' ? 'gb':Session::get('lang')}}"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{action('Client\ClientController@changeLang','sk')}}"><span class="flag-icon flag-icon-sk"></span></a></li>
                        <li><a href="{{action('Client\ClientController@changeLang','cz')}}"><span class="flag-icon flag-icon-cz"></span></a></li>
                        <li><a href="{{action('Client\ClientController@changeLang','en')}}"><span class="flag-icon flag-icon-gb"></span></a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>