<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center text-uppercase">
      <span class="brand-text font-weight-light">Expense Manager</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/images/user-icon.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @if(Auth::user()->role_id != 1)
          <li class="nav-item">
            <router-link to="/home" class="nav-link">
              <i class="nav-icon fas fas fa-tachometer-alt"></i>
              <p>
                Dashboard
               
              </router-link>
            </a>
        </li>
            <li class="nav-item">
              <router-link to="/expenses" class="nav-link">
                  <i class="fas fa-dollars-sign nav-icon"></i>
                <p>Expenses</p>
              </router-link>
            </li>
          @else
          <li class="nav-item">
            <router-link to="/home" class="nav-link">
              <i class="nav-icon fas fas fa-tachometer-alt"></i>
              <p>
                Dashboard
               
              </router-link>
            </a>
        </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/roles" class="nav-link">
                    <i class="fas fa-dollars-sign nav-icon"></i>
                  <p>Roles</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                    <i class="fas fa-dollars-sign nav-icon"></i>
                  <p>User</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Expense Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/categories" class="nav-link">
                    <i class="fas fa-dollars-sign nav-icon"></i>
                  <p>Expense Categories</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/expenses" class="nav-link">
                    <i class="fas fa-dollars-sign nav-icon"></i>
                  <p>Expenses</p>
                </router-link>
              </li>
          @endif
            <li class="nav-item">
              <router-link to="/changepassword" class="nav-link">
                  <i class="fas fa-dollars-sign nav-icon"></i>
                <p>Change Password</p>
              </router-link>
            </li>
            </ul>
          </li>
          
          
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>