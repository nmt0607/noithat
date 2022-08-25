<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                        <p>Cấu hình chung</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.config.seoConfig')}}" class="nav-link {{setActive2('config/seo-config')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cấu hình SEO</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{route('admin.config.siteConfig')}}" class="nav-link {{setActive2('config/site-config')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cấu hình trang</p>
                    </a>
                </li> --}}
            </ul>
        </li>
        <li class="nav-item {{setOpen('advise-list')}} {{setOpen('faqs')}} {{setOpen('question-of-customer')}}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Khách hàng
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.advise.index')}}" class="nav-link {{setActive2('advise-list')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Đăng ký nhận tư vấn</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.question-of-customer.index')}}" class="nav-link {{setActive2('question-of-customer')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Câu hỏi của khách hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.faqs.index')}}" class="nav-link {{setActive2('faqs')}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Câu hỏi thường gặp</p>
                    </a>
                </li>
            </ul>
        </li>
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
        <li class="nav-item">
            <a href="{{route('admin.news.index')}}" class="nav-link {{setActive2('news')}}">
                <i class="nav-icon fas fa-envelope nav-icon"></i>
                <p>Quản lý tin tức</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.files.index')}}" class="nav-link {{setActive2('files')}}">
                <i class="nav-icon far fas fa-file"></i>
                <p>Quản lý Files</p>
            </a>
        </li>

    </ul>
</nav>