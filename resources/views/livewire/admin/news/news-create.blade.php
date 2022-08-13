<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Thêm mới bài viết
            </h4>
        </div>
    </div>

    <!-- Title -->
    {{ Form::open(['url' => route('admin.news.store'), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'name'=>'news_form']) }}
    @csrf
    <div class="card">
        <div class="card-body p-2">
            <div class="form_status">
                <label>Trạng thái: </label>
                <div class="btn" id="changeStatus">
                    <i class="fas fa-toggle-on text-primary text-lg"></i>
                </div>
                <input type="hidden" class="custom-control-input" id="customSwitch1" name="status" value="1">
            </div>

            <div class="form_title">
                <label>Tiêu đề <span class="text-danger">(*)</span> </label>
                <div class="row">
                    <div class="col mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="nameViPrepend">
                                    vi
                                </span>
                            </div>
                            <input value="{{ isset($info) ? $info->name_vi : null }}" type="text" class="@error('name_vi') is-invalid @enderror form-control-sm form-control custom-input-control" id="name_vi" placeholder="Nhập tiêu đề" aria-describedby="nameViPrepend" name="name_vi">
                        </div>
                        @error('name_vi')
                        @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="nameEnPrepend">
                                    en
                                </span>
                            </div>
                            <input value="{{ isset($info) ? $info->name_en : null }}" type="text" class="@error('name_en') is-invalid @enderror form-control-sm form-control custom-input-control" id="name_en" placeholder="Nhập tiêu đề" aria-describedby="nameEnPrepend" name="name_en">
                        </div>
                        @error('name_en')
                        @include('layouts.partials.text._error')
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form_title">
                <label>Mô tả <span class="text-danger">(*)</span></label>
                <div class="row">
                    <div class="col mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="introViPrepend">
                                    vi
                                </span>
                            </div>
                            <textarea aria-describedby="introViPrepend" class="@error('intro_vi') is-invalid @enderror border form-control" name="intro_vi" rows="5">{{ isset($info) ? $info->intro_vi : null }}</textarea>
                        </div>
                        @error('intro_vi')
                        @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="introEnPrepend">
                                    en
                                </span>
                            </div>
                            <textarea aria-describedby="introEnPrepend" class="@error('intro_en') is-invalid @enderror border form-control" name="intro_en" rows="5">{{ isset($info) ? $info->intro_en : null }}</textarea>
                        </div>
                        @error('intro_en')
                        @include('layouts.partials.text._error')
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="form_content">
                <label>Nội dung (vi) </label>
                <div class="form-group">
                    {!! Form::textarea('content_vi', isset($info) ? $info->content_vi : null , array('class' => 'textarea', 'id' => 'content_vi')) !!}
                </div>
            </div>

            <div class="form_content">
                <label>Nội dung (en) </label>
                <div class="form-group">
                    {!! Form::textarea('content_en', isset($info) ? $info->content_en : null, array('class' => 'textarea', 'id' => 'content_en')) !!}
                </div>
            </div>

            <!-- Meta title -->
            <div class="form_title">
                <label>Meta title </label>
                <div class="row">
                    <div class="col mb-3">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="metaTitleViPrepend">
                                    vi
                                </span>
                            </div>
                            <input value="{{ isset($info) ? $info->meta_title_vi : null }}" type="text" class="form-control-sm form-control custom-input-control" id="meta_title_vi" placeholder="Nhập tiêu đề" aria-describedby="metaTitleViPrepend" name="meta_title_vi">
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="metaTitleEnPrepend">
                                    en
                                </span>
                            </div>
                            <input value="{{ isset($info) ? $info->meta_title_en : null }}" type="text" class="form-control-sm form-control custom-input-control" id="meta_title_en" placeholder="Nhập tiêu đề" aria-describedby="metatTitleEnPrepend" name="meta_title_en">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meta description -->
            <div class="form_title">
                <label>Meta description </label>
                <div class="row">
                    <div class="col mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="metaDesViPrepend">
                                    vi
                                </span>
                            </div>
                            <textarea aria-describedby="metaDesViPrepend" class="border form-control" name="meta_des_vi" rows="5">{{ isset($info) ? $info->meta_des_vi : null }}</textarea>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-xs" id="metaDesEnPrepend">
                                    en
                                </span>
                            </div>
                            <textarea aria-describedby="metaDesEnPrepend" class="border form-control" name="meta_des_en" rows="5">{{ isset($info) ? $info->meta_des_en : null }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Author --}}
            <div class="form_content">
                <label>Tác giả</label>
                <div class="form-group">
                    {!! Form::textarea('author', isset($info) ? $info->author : null, array('class' => 'form-control', 'id' => 'author')) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label>Chọn loại tin tức </label>
                    <div class="form-group col-md-3">
                        <div class="select-category">
                            <select class="form-select form-control" aria-label="Default select example" name="category">
                                <option value="1" {{isset($info)?($info->category == 1 ?'selected':''):"selected"}}>Tin thường</option>
                                <option value="2" {{isset($info)?($info->category == 2 ?'selected':''):""}}>Tin nổi bật</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label>Ngày đăng tin </label>
                    <div class="form-group col-md-3">
                        <input value="{{ isset($info) ? $info->date_submit : null }}" type="date" class="form-control-sm form-control custom-input-control" name="date_submit">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label>Chọn ảnh đại diện</label>
                        <div class="">
                            <input type="file" name="image" id="choseFile" />
                            <div class="preview-image mt-2">
                                @if(isset($info) && $info->image)
                                <img src="{{ $info['image'] }}" width="80px" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100 clearfix my-2">
                <button type="button" class="float-right btn ml-1 btn-primary" id='btn-save'>Lưu</button>
                <a href="{{ route('admin.news.index') }}">
                    <button type="button" class="btn btn-outline-primary float-right mr-1">Hủy</button>
                </a>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@if (isset($info))
<script>
    document.getElementById("content_vi").text = null;
    document.getElementById("content_en").text = null;
    $("document").ready(function() {
        $('#content_vi').val('')
        $('#content_en').val('')
        $('#content_vi').summernote('code', {
            !!json_encode(chuanHoa($info - > content_vi)) ?? ''!!
        });
        $('#content_en').summernote('code', {
            !!json_encode(chuanHoa($info - > content_en)) ?? ''!!
        });
    })
</script>
@else
<script>
    $("document").ready(function() {
        $('#content_vi').val('')
        $('#content_en').val('')
        $('#content_vi').summernote('code', {
            !!(json_encode(old('content_vi'))) ?? ''!!
        });
        $('#content_en').summernote('code', {
            !!(json_encode(old('content_en'))) ?? ''!!
        });
    })
</script>
@endif
<script>
    $(function() {
        $(document).on("click", '#changeStatus', function() {
            var x = $(this),
                n = x.siblings("input[type='hidden']"),
                v = (!(n.val() * 1)) * 1,
                ar = ['off text-secondary', 'on text-primary'];
            x.empty().append(
                $("<i>", {
                    class: "text-lg fa fa-toggle-" + ar[v]
                })
            );
            n.val(v);
        });

        $("#choseFile").change(function() {
            const preview = $(".preview-image");
            const file = this.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.empty().append(
                    $("<img>", {
                        src: reader.result,
                        width: 70
                    })
                );
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        // xử lý khi gửi form
        $('#btn-save').click(function(e) {
            e.preventDefault();
            $(this).attr('disabled', true)
            form = document.forms['news_form']
            form.submit()
        })
    });
</script>