<nav class="lighten-1 brown" role="navigation">
    <div class="nav-wrapper container">
        @guest
            <b>
                <a id="logo-container" href="#" class="brand-logo center">
                    <router-link to='/home'>BookShop</router-link>
                </a>
            </b>
        @endguest
        @auth
            <b>
                <a id="logo-container" href="{{ route('product.index')}}" class="brand-logo center">
                    BookShop
                </a>
            </b>
        @endauth
        <ul class="left hide-on-med-and-down">
            <b>
                @guest
                    <li><a href="#"><router-link to='/about'>關於網站</router-link></a></li>
                    <li><a href="#"><router-link to='/disclaimer'>網站聲明</router-link></a></li>
                @endguest
                @auth
                    <li><a href="#">{{ Auth::user()->name }}</a></li>
                    <li><a href="#">{{ Auth::user()->account }}</a></li>
                @endauth
            </b>
        </ul>
        <ul class="right hide-on-med-and-down">
            <b>
                @auth
                    <li><a href="{{route('profile.index')}}">個人資訊</a></li>
                    @if(Auth::user()->administration == 5)
                        <li><a href="{{route('management.index')}}">後台</a></li>
                    @endif
                @endauth
            </b>
        </ul>
        <a href="#" data-target="slide-out" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
    </div>
</nav>
<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="responsive-img" class="background">
                <img class="responsive-img" src="{{ asset('images/SHOP.png') }}">
            </div>
        </div>
    </li>
    @auth
        <b>
            <li><a class="waves-effect"><i class="material-icons">info_outline</i>使用者資訊</a></li>
            <li><a class="waves-effect">{{ Auth::user()->name }}</a></li>
            <li><a class="waves-effect">{{ Auth::user()->account }}</a></li>
        </b>
    @endauth
    @guest
        <b>
            <li>
                <ul class="collapsible collapsible-accordion">
                    <li><a href="#"><router-link to='/about'>關於網站</router-link></a></li>
                    <li><a href="#"><router-link to='/disclaimer'>網站聲明</router-link></a></li>
                </ul>
            </li>
        </b>
    @endguest
    <li><a class="waves-effect"><i class="material-icons">info_outline</i>開發者資訊</a></li>
    <li><a class="waves-effect">開發者:SSSS</a></li>
    <li><a class="waves-effect">信箱:ssss.gladmasy@gmail.com</a></li>
</ul>