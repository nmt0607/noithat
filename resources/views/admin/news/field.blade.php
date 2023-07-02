
<!-- Title -->
@csrf

<div class="form_title">
    <label>Tiêu đề <span class="text-danger">(*)</span> </label>
    <div class="row">
        <div class="col mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text text-xs" >
                        Tiêu đề bài viết
                    </span>
                </div>
                <input value="{{ isset($info) ? $info->title : null }}" type="text" class="@error('name_vi') is-invalid @enderror form-control-sm form-control custom-input-control" id="name_vi" placeholder="Nhập tiêu đề" name="title">
            </div>
            @error('title')
                @include('layouts.partials.text._error')
            @enderror
        </div>
    </div>
</div>

<div class="form_content">
    <label>Giới thiệu</label>
    <div class="form-group">
        {!! Form::textarea('intro', isset($info) ? $info->intro : null , array('class' => 'textarea', 'id' => 'intro', 'rows' => 4, 'cols' => 220)) !!}
    </div>
</div>

<div class="form_content">
    <label>Nội dung</label>
    <div class="form-group">
        {!! Form::textarea('content', isset($info) ? $info->content : null , array('class' => 'textarea', 'id' => 'content')) !!}
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label>Chọn danh mục</label>
        <div class="form-group col-md-3">
            <div class="select-category">
                <select class="form-select form-control" aria-label="Default select example" name="category">
                    <option selected>--Chọn--</option>
                    <option value="1" {{isset($info)?($info->category == 1 ?'selected':''):""}}>Kiến thức nhà đẹp</option>
                    <option value="2" {{isset($info)?($info->category == 2 ?'selected':''):""}}>Kiến thức tổng hợp</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label>Chọn ảnh đại diện</label>
            <div class="">
                <input type="file" name="image" id="choseFile"/>
                <div class="preview-image mt-2">
                    @if(isset($info) && $info->image)
                        <img src="{{asset($info->image)}}"width="80px"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-100 clearfix my-2">
    <button type="submit" class="float-right btn ml-1 btn-primary">Lưu lại</button>
    <a href="{{ route('admin.news.index') }}">
        <button type="button" class="btn btn-secondary float-right mr-1">Hủy</button>
    </a>
</div>
@if (isset($info))
<script>
    document.getElementById("content").text = null;
    $("document").ready(function() {
        $('#content').val('')
        $('#content').summernote('code', {!! json_encode(chuanHoa($info->content)) ??'' !!});
    });
</script>
@else
<script>
    $("document").ready(function() {
        $('#content').val('')
        $('#content').summernote('code', {!! (json_encode(old('content_en'))) ??'' !!});
    })
</script>
@endif
@section('js')
    <script>
        $(function(){
            $(document).on("click", '#changeStatus', function(){
                var x = $(this),
                    n = x.siblings("input[type='hidden']"),
                    v = (!(n.val() *1)) *1,
                    ar = ['off text-secondary', 'on text-primary'];
                x.empty().append(
                    $("<i>",{ class:"text-lg fa fa-toggle-"+ar[v] })
                );
                n.val(v);
            });

            $("#choseFile").change(function(){
                const preview = $(".preview-image");
                const file = this.files[0];
                const reader = new FileReader();

                reader.addEventListener("load", function () {
                    preview.empty().append(
                        $("<img>", { src: reader.result, width: 70 })
                    );
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
