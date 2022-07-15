<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link" style='background-color:#374F65;'>
      <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1.0">
      <span class="brand-text font-weight-light">QLTT</span>
    </a> 

    <!-- Sidebar -->
    <div class="sidebar" style='background-color: #253544 !important;'>
      <!-- Sidebar Menu -->
      @livewire('admin.site.sidebar-list')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
