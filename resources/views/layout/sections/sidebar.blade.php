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
     <li class="nav-item">
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
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#salary_head" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Salary Grade</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="salary_head" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{  url('basicGrade')}}">
              <i class="bi bi-circle"></i><span>Basic Salary Grade</span>
            </a>
          </li>
          <li>
            <a href="{{  url('allBasicGrade')}}">
              <i class="bi bi-circle"></i><span>Grade Listing</span>
            </a>
          </li>
     

        </ul>
      </li> 
      
    </ul>

  </aside>
