

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Messages Dropdown Menu -->
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    {{-- <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ Auth::user()->name }}
      </a>

      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
      </div>
    </li> --}}
    <li class="nav-item" style='margin-right:-13px !important;'>
      <img id='userImage' src="{{Auth()->user()->image?'/'.Auth()->user()->image:asset('images/users/user_dafault.jpg')}}"  class="img-circle" style="opacity: 1.0;width:35px;" />
    </li>
    <li class="dropdown dropdown-user">
        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
        <span id='userName'>{{Auth()->user()->name??''}}</span></a>
        <ul class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('admin.profile.index') }}" style='font-size:14px; color:#6D7C85'><i class="fa fa-user mr-2"></i>Trang cá nhân</a>
            {{--<a class="dropdown-item" href="{{ route('support') }}"><i class="fa fa-support"></i>Hỗ trợ</a> --}}
            <li class="dropdown-divider"></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
            <a class="dropdown-item" style='font-size:14px; color:#6D7C85' href='javascript:void(0);' id='logout'><i class="fa fa-power-off mr-2" ></i>Đăng xuất</a>
        </ul>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<script>
    $("document").ready(() => {
      $('#logout').click(function(){
        $('#logout-form').submit()
      })
    });
</script>