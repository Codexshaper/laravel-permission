 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Laravel Permission</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      
      <!-- Nav Item - Pages Collapse Menu -->
      @role('admin')
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('users') }}">
            <i class="fas fa-user"></i>
            <span>Users</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('permissions.index') }}">
            <i class="fas fa-user-shield"></i>
            <span>Roles &amp; Permissions</span></a>
      </li>
       @endrole

      <!-- Divider -->
      <hr class="sidebar-divider">

    </ul>