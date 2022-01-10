<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      {{-- <img src="{{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('backend') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }} ({{ Auth::user()->role->name }})</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if (Auth::user()->role_id == 1)
          <li class="nav-item">
            <a href="{{ route('admin.teams.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Teams Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User Management
              </p>
            </a>
          </li>
          @elseif (Auth::user()->role_id == 2)
          <li class="nav-item">
            <a href="{{ route('team-leader.projects.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Project Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('team-leader.tasks.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Tasks Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('team-leader.developers.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Developers
              </p>
            </a>
          </li>
          @elseif (Auth::user()->role_id == 3)
          <li class="nav-item">
            <a href="{{ route('developer.projects.list') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Projects 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('developer.tasks.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Tasks 
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ route('developer.tasks.kanban') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Kanban 
              </p>
            </a>
          </li> --}}
          @endif
          
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit()">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Logout
              </p>
              <form action="{{ route('logout') }}" method="post" id="logout-form">
                @csrf 
                
              </form>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>  
