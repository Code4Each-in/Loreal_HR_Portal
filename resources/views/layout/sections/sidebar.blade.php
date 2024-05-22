  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="{{  url('salart-head')}}">
          <i class="bi bi-grid"></i>
          <span>Salary Head</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{  url('allsalaryHead')}}">
          <i class="bi bi-grid"></i>
          <span>All salary Head</span>
        </a>
      </li> -->
      <li class="nav-item">

      <li>
        <a class="nav-link collapsed" href="{{ route('user.listing') }}">
            <i class="bi bi-person"></i>
            <span>Users</span>
            </a>

      </li>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Salary</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{  url('salart-head')}}">
              <i class="bi bi-circle"></i><span>Create Salary Head</span>
            </a>
          </li>
          <li>
            <a href="{{  url('allsalaryHead')}}">
              <i class="bi bi-circle"></i><span>View Salary  Head</span>
            </a>
          </li>
          <li>
            <a href="{{  url('basicGrade')}}">
              <i class="bi bi-circle"></i><span>Basic Grade</span>
            </a>
          </li>

        </ul>
      </li>
    </ul>

  </aside>
