<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Chỉnh sửa File
            </h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">

            <div class="form-group">
                <div class="row">
                    <div class="col-5">
                        <label>Tên file</label>
                        <input class='form-control' placeholder='Tên file' value="{{$file->file_name}}" disabled>
                    </div>
                    <div class="offset-1 col-5">
                        <label>Dung lượng</label>
                        <input class='form-control' placeholder='Dung lượng' value="{{$file->size_file}}" disabled>
                    </div>
                </div> 
                <div class="row mt-2">
                    <div class="col-5">
                        <label>Tên Model</label>
                        <input class='form-control' placeholder='Tên model' value="{{$file->model_name}}" disabled>
                    </div>
                    <div class="offset-1 col-5">
                        <label>Model ID</label>
                        <input class='form-control' placeholder='Model ID' value="{{$file->model_id}}" disabled>
                    </div>
                </div> 
                <div class="row mt-2">
                    <div class="col-11">
                        <label>Url</label>
                        <input class='form-control' placeholder='Url' value="{{$file->url}}" disabled>
                    </div>
                </div> 
                <div class="row mt-2">
                    <div class="col-5">
                        <label>Người đăng</label>
                        <input class='form-control' placeholder='Người đăng' value="{{$user_name}}" disabled>
                    </div>
                    <div class="offset-1 col-5">
                        <label>Ghi chú</label>
                        <input class='form-control' placeholder='ghi chú' wire:model='note'>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="offset-4 col-8">
                <a class="btn btn-outline-primary" type="button" href="{{route('admin.files.index')}}">
                    <i class="ace-icon fa fa-reply bigger-110"></i>
                    Quay lại
                </a>
                &nbsp; &nbsp; &nbsp;
                <button type="submit" class="btn btn-primary" id='btn_save' wire:click='edit'>
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Lưu
                </button>
            </div>
        </div>
    </div>
</div>