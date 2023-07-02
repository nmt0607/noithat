<div id="main_body">
    <section id="breadcrumb-wrapper" class="breadcrumb-w-img" style=" background: url(https://noithatlacgia.vn/wp-content/uploads/2021/07/bg-header-1.jpg);">
        <div class="breadcrumb-overlay"></div>
    </section>
    <div class="beacrum">
        <div class="container">
            <ul class="clearfix">
            <li><a href="{{route('client.home')}}">Trang chủ</a></li>
                <li class="separator">&rsaquo;</li>
                <li class="current">{{$this->typeName??'Sản phẩm tiêu biểu'}}</li>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 content_col fixed-right">
                <h1 class="page-title">{{$this->typeName??'Sản phẩm tiêu biểu'}}</h1>
                <div id="result">
                    <div class="tax_box">
                        <div class="row">
                            @foreach($data as $row)
                            <div class="col-md-4 col-sm-6">
                                <div class="product_item">
                                    <div class="thumb">
                                        <a href="{{route('client.product_detail', ['id' => $row->id])}}"><img width="1920" height="1280" src="{{asset($row->avatar->path)}}" class="img-responsive wp-post-image" alt="" loading="lazy" sizes="(max-width: 1920px) 100vw, 1920px" /></a>
                                    </div>
                                    <div class="item_info">
                                        <h3 class="product_title"><a href="https://noithatlacgia.vn/san-pham/ke-tivi-go-hien-dai-alma-stand/">{{$row->name}}</a></h3>
                                    </div>
                                    <p class="star">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </p>
                                    <div class="box_price">
                                        <div class="col-haflt sale">
                                            <del>
                                                đ
                                            </del>
                                        </div>
                                        <div class="col-haflt">
                                            đ
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-2 sidebar_col fixed-left">
                <div class="sb_content">
                    <div class="box-sidebar">
                        <h3 class="sb_title"><span>{{$this->typeName??'Sản phẩm tiêu biểu'}}</span></h3>
                        <ul class="products-filters">
                            <li class="cat-item selected"><a href="{{route('client.product')}}"><span></span>Sản phẩm tiêu biểu</a></li>
                            @foreach($listPdType as $type) 
                            <li class="cat-item selected"><a href="{{route('client.product',['type_id' => $type->id])}}"><span></span>{{$type->name}}</a></li>
                            <div class="sub_cat">
                                @foreach($type->child as $childType) 
                                <li class="cat-item selected"><a href="{{route('client.product',['type_id' => $childType->id])}}"><span></span>{{$childType->name}}</a></li>
                                @endforeach
                            </div>
                            @endforeach
                        </ul>
                    </div>
                    <!-- <div class="box-sidebar">
        <h3 class="sb_title"><span>Lọc theo khoảng giá</span></h3>
        <div class="inner-box">
            <div id="budget-range"></div>
            <input type="text" id="amount-budget" readonly name="budget">
        </div>
    </div> -->
                </div>
                <link data-minify="1" rel="preload" href="https://noithatlacgia.vn/wp-content/cache/min/1/ui/1.11.4/themes/smoothness/jquery-ui.css?ver=1680521571" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" onerror="this.removeAttribute('data-rocket-async')">
                <script data-minify="1" src="https://noithatlacgia.vn/wp-content/cache/min/1/jquery-1.10.2.js?ver=1680521572"></script>
                <script data-minify="1" src="https://noithatlacgia.vn/wp-content/cache/min/1/ui/1.11.4/jquery-ui.js?ver=1680521574"></script>
                <script type="rocketlazyloadscript">
                    $( function() {
                        $( "#budget-range" ).slider({
                        range: true,
                        min: 0,
                        max: 100000000,
                        values: [ 0, 50000000],
                        step: 10000000,
                        slide: function( event, ui ) {
                            $( "#amount-budget" ).val( "Giá : " + ui.values[ 0 ] + " VNĐ - " + ui.values[ 1 ] + " VNĐ" );
                            ajax_price(ui.values[ 0 ],ui.values[1]);
                        }
                        });
                        $( "#amount-budget" ).val("Giá : " + $( "#budget-range" ).slider( "values", 0 ) +" VNĐ - " + $( "#budget-range" ).slider( "values", 1 )+" VNĐ" );
                        function ajax_price(min_price,max_price){
                                $('#result').html('<div class="text-center"><span class="loading"></span></div>');  
                                $.ajax({
                                    type: 'POST',
                                    url:ajaxurl,
                                    data: { min_price: min_price,max_price : max_price , action : 'price_range' },
                                    dataType: 'html',
                                    success: function(data) {
                                        //console.log(data);
                                        $("#result").html(data);
                                    }
                                });
                        }
                    });
                    </script>
            </div>
        </div>
    </div>
</div> <!-- endmain-body -->
<div id="to_top">
    <a href="#" class="btn btn-primary"><i class="fa fa-angle-double-up"></i></a>
</div>