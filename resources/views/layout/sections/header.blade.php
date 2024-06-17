  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ url('dashboard') }}" class="logo d-flex align-items-center">
        <img src="{{ url('assets/img/logo.png') }}" alt="">
        <span class="d-none d-lg-block">L'Oréal</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <!-- //End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ url('assets/img/profile_image.png') }} " alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">@if(Auth::check()) {{ Auth::user()->Fname }}  @endif</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>@if(Auth::check()) {{ Auth::user()->Fname }}  @endif</h6>
              <span></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

          
            <li>
              <hr class="dropdown-divider">
            </li>

          
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->

        </li><!-- End Profile Nav -->

      </ul>
          @if(session()->has('permission_error'))
       <div class="alert alert-danger header-alert fade show" role="alert" id="header-alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ session()->get('permission_error') }}
        </div>
        @endif    
    </nav><!-- End Icons Navigation -->


  </header><!-- End Header -->
