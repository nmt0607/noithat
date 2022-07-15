<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item {{setOpen('user')}} {{setOpen('role')}}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>Người dùng
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.user.index')}}" class="nav-link {{setActive2('user')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách người dùng</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{setOpen('config')}}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-gear"></i>
                <p>Cấu hình
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.config.masterData')}}" class="nav-link {{setActive2('config/master-data')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Master data</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.news.index')}}" class="nav-link {{setActive2('news')}}">
                <i class="far far fa-envelope nav-icon"></i>
                <p>Quản lý tin tức</p>
            </a>
        </li>
    </ul>
</nav>