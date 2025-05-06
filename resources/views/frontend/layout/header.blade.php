
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{url('/')}}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">Mentor</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url(path: '/')}}" class="@yield('home_active')">Home<br></a></li>
          <li><a href="{{url(path: '/about')}}" class="@yield('about_active')">About</a></li>
          <li><a href="{{url(path: '/courses')}}" class="@yield('course_active')">Courses</a></li>
          <li><a href="{{url(path: '/trainers')}}" class="@yield('trainer_active')">Trainers</a></li>
          <li><a href="{{url(path: '/event')}}" class="@yield('event_active')" >Events</a></li>
          <li><a href="{{url(path: '/pricing')}}" class="@yield('pricing_active')" >Pricing</a></li>
          <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li>
          <li><a href="{{url('/contact')}}" class="@yield('contact_active')" >contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{url('/')}}">Get Started</a>

      <a class="btn-getstarted" href="{{ url('/login') }}">
        Login <i class="fas fa-sign-in-alt"></i>
      </a>
      <a class="btn-getstarted" href="{{ url('/register') }}">
        Register <i class="far fa-registered"></i>
      </a>
      


    </div>
  </header>

