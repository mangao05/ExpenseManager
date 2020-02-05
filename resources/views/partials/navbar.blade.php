<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
			<a href="#" class="nav-link font-weight-bold">
				Welcome to Expense Manager!
			</a>
		</li>
        <li class="nav-item">
			<a 
				href="{{ route('logout') }}"
				onclick="event.preventDefault();
				document.getElementById('logout-form').submit();"
				class="nav-link"
							>
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </li>
    </ul>
  </nav>
  <!-- /.navbar -->