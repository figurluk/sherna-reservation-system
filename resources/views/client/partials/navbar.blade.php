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
            <a class="navbar-brand" href="{{action('Client\ClientController@index')}}">SHerna</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O Projektu</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{action('Client\ClientController@show','o-sherne')}}">O SHerne</a></li>
                        <li><a href="{{action('Client\ClientController@show','clenove')}}">Clenove</a></li>
                        <li><a href="{{action('Client\ClientController@show','vyrocni-spravy')}}">Vyrocni spravy</a></li>
                    </ul>
                </li>
                <li><a href="{{action('Client\ClientController@show','rezervace')}}">Rezervace</a></li>
                <li><a href="{{action('Client\ClientController@show','turnaje')}}">Turnaje</a></li>
                <li><a href="{{action('Client\ClientController@show','vybaveni')}}">Vybaveni</a></li>
                @if(Auth::check() && Auth::user()->admin)
                    @if(Auth::user()->admin())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Meno
                                                                                                                                                priezvisko</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{action('Admin\AdminController@index')}}">Administrace</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Meno
                                                                                                                                                priezvisko</a>
                            <ul class="dropdown-menu">
                                <li><a href="#contact">Muj profil</a></li>
                                <li><a href="#contact">Rezervace</a></li>
                                <li><a href="#contact">Odhlaseni</a></li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li><a href="#contact">Prihlasit pres IS</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>