  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">

      <li>
        <a class="nav-link collapsed" href="{{ route('user.listing') }}">
            <i class="bi bi-person"></i>
            <span>Users</span>
            </a>

      </li>
      <li>
        <a class="nav-link collapsed" href="{{  url('salary_head_listing')}}">
            <i class="bi bi-menu-button-wide"></i>
            <span>Salary Head Listing</span>
            </a>

      </li>
      <li>
        <a class="nav-link collapsed" href="{{  url('grade_listing')}}">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Grade Listing</span>
            </a>

      </li>
      <li>
        <a class="nav-link collapsed" href="{{ url('basic_grade_salary_master_listing') }}">
            <i class="bi bi-layout-text-window-reverse"></i>
            <span>Grade Salary Listing</span>
            </a>

      </li>
      <li>
        <a class="nav-link collapsed" href="{{  url('emp_listing')}}">
            <i class="bi bi-person"></i>
            <span>Employee Listing </span>
            </a>

      </li>
     
     <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Master Salary Head</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{  url('master_salary_head')}}">
              <i class="bi bi-circle"></i><span>Create Salary Head</span>
            </a>
          </li>
          <li>
            <a href="{{  url('salary_head_listing')}}">
              <i class="bi bi-circle"></i><span>Salary Head Listing</span>
            </a>
          </li>
        </ul>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#salary_head" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Salary Grade</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="salary_head" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{  url('create_grade')}}">
              <i class="bi bi-circle"></i><span>Create Grade</span>
            </a>
          </li>
          <li>
            <a href="{{  url('grade_listing')}}">
              <i class="bi bi-circle"></i><span>Grade Listing</span>
            </a>
          </li>

        </ul>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#employee" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Employee</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="employee" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        
          <li>
            <a href="{{  url('emp_listing')}}">
              <i class="bi bi-circle"></i><span>Employee Listing</span>
            </a>
          </li>
        </ul>
      </li> -->

            <!-- <a class="nav-link collapsed" data-bs-target="#basic_grade_salary_master" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Basic Grade Salary Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a> -->
            <!-- <ul id="basic_grade_salary_master" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('basic_grade') }}">
                        <i class="bi bi-circle"></i><span>Create BasicSalary</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('basic_grade_salary_master_listing') }}">
                        <i class="bi bi-circle"></i><span>Basic Grade Salary Listing</span>
                    </a>
                </li>
            </ul> -->
        </li>
    </ul>

  </aside>
