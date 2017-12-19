<script type="text/javascript" id="cookieinfo"
        src="{{asset('js/cookieinfo.min.js')}}"
        data-bg="rgba(0,0,0,.8)"
        data-fg="#FFFFFF"
        data-link="#FF9800"
        data-moreinfo="http://{{Config::get('app.locale')}}.wikipedia.org/wiki/HTTP_cookie"
        data-cookie="ShernaCookieInfoScript"
        data-expires="{{gmdate('D, d M Y H:i:s \G\M\T', time() + 1209600)}}"
        data-text-align="left"
        data-message="{{trans('cookies.text')}}"
        data-linkmsg="{{trans('cookies.more')}}"
        data-font-family="'Roboto', Arial, sans-serif"
        data-close-text="{{trans('cookies.button')}}" async defer>
</script>