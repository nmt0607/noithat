<div id="main_body">
    <link rel="preload" href="https://noithatlacgia.vn/wp-content/themes/lacgia/css/jquery.fancybox.min.css" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" />
    <section id="breadcrumb-wrapper" class="breadcrumb-w-img" style=" background: url(https://noithatlacgia.vn/wp-content/uploads/2021/07/bg-header-1.jpg);">
        <div class="breadcrumb-overlay"></div>
    </section>
    <div class="beacrum">
        <div class="container">
            <ul class="clearfix">
                <li><a href="{{route('client.home')}}">Trang chủ</a></li>
                <li class="separator">&rsaquo;</li>
                <li class="current">{{$product->name}}</li>
            </ul>
        </div>
    </div>
    <div class="head_product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="fixedpro">
                        <div class="box_foto">
                            <div class="img_zoom">
                                @foreach($product->images as $row)
                                    @if ($loop->first)                                
                                        <a data-fancybox="gallery" href="{{asset($row->path)}}">
                                            <div class="icon_zoom" data-toggle="tooltip" data-placement="top" title="zoom"><i class="fa fa-expand"></i></div>
                                        </a>
                                    @else
                                        <a data-fancybox="gallery" href="{{asset($row->path)}}"></a>
                                    @endif
                                @endforeach
                            </div>
                            <script src="https://noithatlacgia.vn/wp-content/themes/lacgia/js/jquery.min.js"></script> <!-- 33 KB -->
                            <link data-minify="1" href="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/css/fotorama.css?ver=1680517936" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')" rel="preload"> <!-- 3 KB -->
                            <script data-minify="1" src="https://noithatlacgia.vn/wp-content/cache/min/1/wp-content/themes/lacgia/js/fotorama.js?ver=1680517936"></script> <!-- 16 KB -->
                            <div class="fotorama" data-nav="thumbs" data-width="710" data-height="474">
                                @foreach($product->images as $row)
                                <a href="{{asset($row->path)}}"><img src="{{asset($row->path)}}" width="150" height="100" data-caption="alma-sofa (2)"></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="meta_pro">
                        <div class="product_detail">
                            <h1 class="single-title-product product-title"><span>{{$product->name}}</span></h1>
                            <div class="box_meta">
                                <div class="meta_col">
                                    <div class="pro_info">
                                        <p><strong>Mã sản phẩm: {{$product->code}}</strong></p>
                                        <p><strong>Chất liệu: {{$product->material}}</strong></p>
                                        <p><strong>Tình trạng hàng: <span style="color:#ff6e08;">{{$product->status}}</span></strong></p>
                                        <p><strong>Bảo hành: {{$product->guarantee}}</strong></p>
                                        <p><strong>Miễn phí vận chuyển nội thành</strong></p>
                                    </div>
                                    <ul class="all-tt">
                                        <li class="gia gia-ban">
                                                {{$product->price}}
                                        </li>
                                    </ul>
                                    <p class="note">Giá gỗ óc chó</p>
                                    <div class="box_call">
                                        <a href="tel:0836 555 355">
                                            <h4 class="hotline">0836 555 355</h4>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-6">
                                            <div class="box_meta_z">
                                                <img src="https://noithatlacgia.vn/wp-content/themes/lacgia/images/freeship.png" class="pro_icon">
                                                <h4 class="tit_icon">Miễn phí vận chuyển</h4>
                                                <hr>
                                                <p>Trong nội thành Hà Nội</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <div class="box_meta_z">
                                                <img src="https://noithatlacgia.vn/wp-content/themes/lacgia/images/setup.png" class="pro_icon">
                                                <h4 class="tit_icon">Miễn phí lắp đặt</h4>
                                                <hr>
                                                <p>Tư vấn thiết kế miễn phí</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="content_info col-md-12">
                    <div class="tabbed-content">
                        <ul class="nav nav-pills">
                            <li class="tab has-icon active">
                                <a href="#tab1" data-toggle="pill">
                                    <span>Mô tả</span>
                                </a>
                            </li>
                            <li class="tab has-icon">
                                <a href="#tab2" data-toggle="pill">
                                    <span>Thông số kỹ thuật</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1">
                                
                                <h2 style="text-align: center;">Sofa gỗ tự nhiên Alma</h2>
                                @foreach($product->images as $row)
                                    <p><img loading="lazy" class="aligncenter size-full wp-image-3674" src="{{asset($row->path)}}" alt="Alma Sofa" width="1920" height="1280" sizes="(max-width: 1920px) 100vw, 1920px" /></p>
                                    <p>&nbsp;</p>
                                @endforeach
                                <p><strong>+ Quý khách có thể đặt hàng qua :</strong></p>
                                <p><strong>- Liên hệ H</strong><b>otline</b>: <a href="tel:0836555355">0836.555.355</a></p>
                                <p><strong>- Đ</strong><b>ến trực tiếp tại showroom: (</b><a href="https://noithatlacgia.vn/so-do-chi-duong/" rel="nofollow">Chỉ dẫn đường đi tới Showroom Nội Thất Lạc Gia</a><b>)</b></p>
                                <p><strong>- Đặt lịch tư vấn miễn phí tại nhà</strong> (<a href="https://noithatlacgia.vn/lien-he/" rel="nofollow">Liên hệ ngay</a>)</p>
                                <p><b></b><strong>+ Thời gian giao hàng: </strong>Sản phẩm sẽ được bàn giao cho quý khách sau<strong> 3 ngày</strong> nếu tình trang hàng có sẵn và sau <strong>10 - 15 ngày</strong> nếu đóng đặt (thời gian được tính kể từ ngày chốt đơn hàng).</p>
                            </div>
                            <div class="tab-pane fade in" id="tab2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="tskt_box">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p_luuy">
                                            <h3 class="note_product">Lưu ý</h3>
                                            <p>1. Quý khách hàng có thể đặt hàng theo kích thước riêng. Đối với khách hàng ở Hà Nội, chúng tôi hỗ trợ đến tấn nơi đo đạc </p>
                                            <p>2. Tất cả nguyên liệu gỗ Óc Chó, Tần Bì đều được nhập khẩu nguyên kiện từ nước ngoài.</p>
                                            <p>3. Quý khách xem thêm bảng giá theo chất liệu gỗ bên dưới</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="related_box">
                    <div class="related_posts media_posts posts">
                        <h2 class="product_title_relate"><span>Sản phẩm liên quan</span></h2>
                        <div class="rows">
                            @forelse($productRelated as $row)
                            <div class="col-md-3">
                                <div class="product_item">
                                    <div class="thumb">
                                        <a href="{{route('client.product_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->avatar->path)}}" class="img-responsive wp-post-image" alt="Farah Sofa" loading="lazy"/></a>
                                    </div>
                                    <div class="item_info">
                                        <h3 class="product_title"><a href="{{route('client.product_detail', ['id' => $row->id])}}">{{$row->name}}</a></h3>
                                    </div>
                                    <p class="star">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </p>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!-- endmain-body -->
<div id="to_top">
    <a href="#" class="btn btn-primary"><i class="fa fa-angle-double-up"></i></a>
</div>