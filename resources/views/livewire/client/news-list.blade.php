<div id="main_body">
    <section id="breadcrumb-wrapper" class="breadcrumb-w-img" style=" background: url(https://noithatlacgia.vn/wp-content/uploads/2021/07/bg-header-1.jpg);">
        <div class="breadcrumb-overlay"></div>
    </section>
    <div class="beacrum">
        <div class="container">
            <ul class="clearfix">
                <li><a href="{{route('client.home')}}">Trang chủ</a></li>
                <li class="separator">&rsaquo;</li>
                <li class="current">{{$typeName}}</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="md-full">
                <h1 class="page-title">{{$typeName}}</h1>
                <div class="blog-single-slider grid">
                    <div class="row">
                        @foreach($data as $row)
                        @if ($loop->first)
                        <div class="col-md-8 col-sm-6">
                            <div class="post_col">
                                <div class="thumb ft_thumb">
                                    <a href="{{route('client.news_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->image)}}" class="img-responsive full wp-post-image" alt="Thiết kế nội thất nhà phố gỗ óc chó cao cấp - Chị Lan Khương Thượng"/></a>
                                    <div class="box_ft_ct">
                                        <div class="news_title">
                                            <a href="{{route('client.news_detail', ['id' => $row->id])}}">
                                                <h3 class="news_title_slider">{{$row->title}}</h3>
                                            </a>
                                        </div>
                                        <div class="sub_single_title">
                                            <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 28/12/2022</div>
                                        </div>
                                        <div class="news_exrept">{{$row->intro}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif ($loop->index == 1)
                        <div class="col-md-4 col-sm-6">
                            <div class="post_list_col box_news_2">
                                <div class="thumb">
                                    <a href="{{route('client.news_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->image)}}" class="img-responsive wp-post-image" alt="Thiết kế nội thất biệt thự KĐT Vĩnh Yên - Chị Tâm" loading="lazy"  sizes="(max-width: 1920px) 100vw, 1920px" /></a>
                                </div>
                                <div class="news_title">
                                    <a href="{{route('client.news_detail', ['id' => $row->id])}}">
                                        <h3 class="news_title_slider">{{$row->title}}</h3>
                                    </a>
                                </div>
                                <div class="sub_single_title">
                                    <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 12/12/2022</div>
                                </div>
                                <div class="news_exrept">{{$row->intro}}</div>
                            </div>
                        </div>
                        @else
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-6">
                            <div class="post_list_col box_news_3">
                                <div class="thumb">
                                    <a href="{{route('client.news_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->image)}}" class="img-responsive wp-post-image" alt="Thiết kế nội thất biệt thự thông tầng sang trọng A Dương - Bình Dương" loading="lazy"/></a>
                                </div>
                                <div class="news_title">
                                    <a href="{{route('client.news_detail', ['id' => $row->id])}}">
                                        <h3 class="news_title_slider">{{$row->title}}</h3>
                                    </a>
                                </div>
                                <div class="sub_single_title">
                                    <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> 17/11/2022</div>
                                </div>
                                <div class="news_exrept">{{$row->intro}}</div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="paginate">
                    <span aria-current="page" class="page-numbers current">1</span>
                    <a class="page-numbers" href="https://noithatlacgia.vn/tin-tuc/page/2/">2</a>
                    <a class="page-numbers" href="https://noithatlacgia.vn/tin-tuc/page/3/">3</a>
                    <span class="page-numbers dots">&hellip;</span>
                    <a class="page-numbers" href="https://noithatlacgia.vn/tin-tuc/page/11/">11</a>
                    <a class="next page-numbers" href="https://noithatlacgia.vn/tin-tuc/page/2/">&rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div> <!-- endmain-body -->