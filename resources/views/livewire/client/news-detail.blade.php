<div id="main_body">
    <section id="breadcrumb-wrapper" class="breadcrumb-w-img" style=" background: url(https://noithatlacgia.vn/wp-content/uploads/2021/07/bg-header-1.jpg);">
        <div class="breadcrumb-overlay"></div>
    </section>
    <div class="beacrum">
        <div class="container">
            <ul class="clearfix">
                <li><a href="{{route('client.home')}}">Trang chủ</a></li>
                <li class="separator">&rsaquo;</li>
                <li><a href="{{route('client.news')}}">Tin tức</a>
                <li class="separator">&rsaquo;</li> <a href="{{route('client.news' ,['type_id' => $news->category])}}">{{$news->categoryName()}}</a>
                <li class="separator">&rsaquo;</li>
                </li>
                <li class="current">{{$news->title}}</li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 content_col">
                <h1 class="single-title"><span>{{$news->title}}</span></h1>
                {!!$news->content!!}
                <div class="related_box">
                    <h3 class="related_title text-left"><span>Bài viết liên quan</span></h3>
                    <div class="related_posts">
                        <ul class="related_post_list">
                            @foreach($newsRelated as $row)
                            <li><a href="{{route('client.news_detail', ['id' => $row->id])}}">{{$row->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 sidebar_col">
                <div class="sb_content">
                    <div class="sb_box newest">
                        <h3 class="sb_title"><span>Bài viết mới nhất</span></h3>
                        <div class="media_posts posts">
                            @foreach($newsList as $row)
                            <a class="post media" href="{{route('client.news_detail', ['id' => $row->id])}}">
                                <div class="pull-left thumb">
                                    <img width="150" height="150" src="{{asset($row->image)}}" class="media-object wp-post-image" alt="{{$row->title}}" loading="lazy" />
                                </div>
                                <div class="post_desc media-heading">
                                    <h4 class="title">{{$row->title}}</h4>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- endmain-body -->