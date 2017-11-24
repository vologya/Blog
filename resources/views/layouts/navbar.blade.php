<div class="blog-masthead">
  <div class="container">
    <nav class="blog-nav">
      <a class="blog-nav-item 
        {{ (request()->is('/') || request()->is('posts')) ? ' active' : '' }}" 
        href="/">Main Page</a>
      <a class="blog-nav-item 
        {{ request()->is('posts/create') ? ' active' : '' }}" 
        href="{{ route('posts.create') }}">New Post</a>

      <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @guest
            <li><a class="blog-nav-item" href="{{ route('login') }}">Login</a></li>
            <li><a class="blog-nav-item" href="{{ route('register') }}">Register</a></li>
        @else
            <li class="dropdown">
                <a href="#" class="blog-nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('home') }}">
                          Home
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endguest
    </ul>

    </nav>
  </div>
</div>