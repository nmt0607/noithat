<div class="col-md-9 custom">
    <nav id="topmenu" class="navbar navbar-default" style="float: left">

        <div id="bsmenu" class="collapse navbar-collapse">
            <ul id="menu-topmenu" class="nav navbar-nav">
                <li id="menu-item-354" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-3 current_page_item menu-item-354 active"><a title="Trang chủ" href="{{route('client.home')}}">Trang chủ</a></li>
                <li id="menu-item-655" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-655 dropdown"><a title="Sản phẩm" href="{{route('client.product')}}" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Sản phẩm <span class="fa fa-angle-down"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        @foreach($parentTypeList as $parentType)
                        <li id="menu-item-659" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-659 dropdown"><a title="Phòng khách" href="{{route('client.product',['type_id' => $parentType->id])}}">{{$parentType->name}}</a>                       
                            <ul role="menu" class=" dropdown-menu">
                                @foreach($parentType->child as $type)
                                    <li id="menu-item-660" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-660"><a title="Sofa gỗ" href="{{route('client.product',['type_id' => $type->id])}}">{{$type->name}}</a></li>
                                @endforeach
                            </ul>                           
                        </li>
                        @endforeach
                       
                    </ul>
                </li>
                <li id="menu-item-358" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-358 dropdown"><a title="Tin tức" href="{{route('client.news')}}" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Tin tức <span class="fa fa-angle-down"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        <li id="menu-item-675" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-675"><a title="Kiến thức nhà đẹp" href="{{route('client.news' ,['type_id' => 1])}}">Kiến thức nhà đẹp</a></li>
                        <li id="menu-item-676" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-676"><a title="Kiến thức tổng hợp" href="{{route('client.news' ,['type_id' => 2])}}">Kiến thức tổng hợp</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>