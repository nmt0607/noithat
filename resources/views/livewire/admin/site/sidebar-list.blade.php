<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('admin.master-data')}}" class="nav-link {{setActive('admin/master-data')}}">
                <p>Cấu hình chung</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.product-type')}}" class="nav-link {{setActive('admin/product-type')}}">
                <p>Quản lý Danh mục sản phẩm</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.product')}}" class="nav-link {{setActive2('admin/product')}} {{setActive('admin/product/')}} {{setActive('admin/product/create')}}">
                <p>Quản lý Sản phẩm</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.news.index')}}" class="nav-link {{setActive2('admin/news')}} {{setActive('admin/news/')}} {{setActive('admin/news/create')}}">
                <p>Quản lý Tin tức</p>
            </a>
        </li>
    </ul>
</nav>