<div id="main_body">
    <div id="home_slider">
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="6500">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
                <li data-target="#myCarousel" data-slide-to="5"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach($banner->images as $row)
                @if($loop->first)
                <div class="item active">
                @else
                <div class="item no-active">
                @endif
                    <li>
                        <a href="" target="_blank">
                            <img width="1920" height="960" src="{{asset($row->path)}}" class="img-responsive wp-post-image" loading="lazy"  sizes="(max-width: 1920px) 100vw, 1920px" />
                    </li>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <section id="home-parallax">
        <div class="container">
            <div class="inner">
                <h2 class="section-title text-center">Sản phẩm nội thất tiêu biểu</h2>
                <div class="box_product">
                    <div class="row">
                        @foreach($productList as $row)
                        <div class="col-md-4 col-sm-6">
                            <div class="product_item">
                                <div class="thumb">
                                    <a href="{{route('client.product_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->avatar->path)}}" class="img-responsive wp-post-image" alt="Farah Sofa" loading="lazy"  sizes="(max-width: 1920px) 100vw, 1920px" /></a>
                                </div>
                                <div class="item_info">
                                    <h3 class="product_title"><a href="{{route('client.product_detail', ['id' => $row->id])}}">{{$row->name}}</a></h3>
                                </div>
                                <p class="star">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="home-testimonials" style=" background: url(https://noithatlacgia.vn/wp-content/uploads/2021/07/testi.jpg);">
        <div class="ht-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="gt_lg">
                        <h3 class="title text-uppercase">Nội thất lạc gia</h3>
                        <div class="box_text">
                            <p style="text-align: justify;">{{$intro->content}}</p>
                        </div>
                        <button class="btn btn-view">
                            <a href="https://noithatlacgia.vn/gioi-thieu">
                                Giới thiệu về nội thất Lạc Gia
                            </a>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box_video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/nCwdGt9hxhE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="tintuc">
        <div class="container">
            <h2 class="section-title text-center">Tin tức</h2>
            <div class="box_tintuc">
                <div class="row">
                    @foreach($newsList as $row)
                    <div class="col-md-3">
                        <div class="archive_col">
                            <div class="thumb">
                                <a href="{{route('client.news_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->image)}}" class="img-responsive wp-post-image" alt="Thiết kế nội thất nhà phố gỗ óc chó cao cấp - Chị Lan Khương Thượng" loading="lazy" sizes="(max-width: 1920px) 100vw, 1920px" /></a>
                            </div>
                            <div class="news_title">
                                <a href="{{route('client.news_detail', ['id' => $row->id])}}">
                                    <h3 class="news_title_slider">{{$row->title}}</h3>
                                </a>
                            </div>
                            <div class="sub_single_title">
                                <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 28/12/2022</div>
                            </div>
                            <div class="news_exrept">
                                {{$row->intro}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div> <!-- endmain-body -->