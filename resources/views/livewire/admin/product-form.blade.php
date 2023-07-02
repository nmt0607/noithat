<div class="body-content p-2">
    <div wire:loading class="loader"></div>
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                @if($editId)
                    Chỉnh sửa sản phẩm
                @else
                    Tạo mới sản phẩm
                @endif
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div>
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>

                <span class="px-2">/</span>

                <div class="">
                    <a href="{{ route('admin.product') }}">Quản lý sản phẩm</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">
                    @if($editId)
                        Chỉnh sửa sản phẩm
                    @else
                        Tạo mới sản phẩm
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Title -->
    <div class="card">
        <div class="card-body p-2">
            <div class="form_title mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Tên sản phẩm: <span class="text-danger"></span> </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input wire:model.defer="name" type="text" class="@error('name') is-invalid @enderror form-control-sm form-control custom-input-control" id="name" placeholder="Nhập tên sản phẩm" aria-describedby="namePrepend" name="name">
                                </div>
                                @error('name')
                                @include('layouts.partials.text._error')
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Mã sản phẩm: <span class="text-danger"></span> </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input wire:model.defer="code" type="text" class="@error('code') is-invalid @enderror form-control-sm form-control custom-input-control" id="code" placeholder="Nhập mã sản phẩm" aria-describedby="codePrepend" name="code">
                                </div>
                                @error('code')
                                @include('layouts.partials.text._error')
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_title mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Chất liệu: <span class="text-danger"></span> </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input wire:model.defer="material" type="text" class="@error('material') is-invalid @enderror form-control-sm form-control custom-input-control" id="material" placeholder="Nhập tên sản phẩm" aria-describedby="materialPrepend" name="material">
                                </div>
                                @error('material')
                                @include('layouts.partials.text._error')
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Tình trạng hàng: </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input wire:model.defer="status" type="text" class="@error('status') is-invalid @enderror form-control-sm form-control custom-input-control" id="status" placeholder="Nhập mã sản phẩm" aria-describedby="statusPrepend" name="status">
                                </div>
                                @error('status')
                                @include('layouts.partials.text._error')
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_title mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Thời hạn bảo hành: <span class="text-danger"></span> </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input wire:model.defer="guarantee" type="text" class="@error('guarantee') is-invalid @enderror form-control-sm form-control custom-input-control" id="guarantee" placeholder="Nhập thời hạn bảo hành" aria-describedby="guaranteePrepend" name="guarantee">
                                </div>
                                @error('guarantee')
                                @include('layouts.partials.text._error')
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Giá: <span class="text-danger"></span> </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input wire:model.defer="price" type="text" class="@error('price') is-invalid @enderror form-control-sm form-control custom-input-control" id="price" placeholder="Nhập mã sản phẩm" aria-describedby="pricePrepend" name="price">
                                </div>
                                @error('price')
                                @include('layouts.partials.text._error')
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_title mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Danh mục: <span class="text-danger"></span> </label>
                            <div class="form-group col-md-3">
                                <div class="select-category">
                                    <select id="pd_type_lv1" wire:model.defer="pd_type_lv1" class="form-control">
                                        <option value="" selected>Chọn danh mục</option>
                                        @foreach($pdTypeList as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 mt-1" style="text-align:right;">Sản phẩm nổi bật: </label>                              
                            <div class="form-group col-md-3 mt-1" class="btn" id="changeType">
                                <i class="fas {{$type==1?'fa-toggle-on':'fa-toggle-off'}} text-primary text-lg"></i>
                            </div>
                            <input type="hidden" class="custom-control-input" id="customSwitch1" name="type" wire:model="type">
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="m-0 ml-2 mt-3 mb-3">
                Danh sách hình ảnh sản phẩm
            </h4>
            <div class="mb-2">
                <div class="mb-2" style="float: right">
                    <a href="#" data-toggle="modal" data-target="#modalAddImage">
                        <div class="btn btn-primary">
                            <i class="fa fa-plus"></i> Tạo mới
                        </div>
                    </a>
                </div>
            </div>
            <table class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                <thead>
                    <tr role='row'>

                        <th class='text-center w-60'>STT</th>
                        <th>Hình ảnh</th>
                        <th>Tên file</th>
                        <th>Chọn làm ảnh đại diện</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($images as $key => $row)
                    <tr>
                        <td class='text-center'>{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</td>
                        <td class='text-center'>
                            @if($row)
                            <img src="{{asset($row->path)}}" class="job-logo-ima" alt="job-logo" width="70px" height="70px">
                            @else
                            No image
                            @endif
                        </td>
                        <td>{{$row->file_name}}</td>
                        <td><i onclick="chooseAvatar({{$row->id}})" class="fas {{$row->type==1?'fa-toggle-on':'fa-toggle-off'}} text-primary text-lg"></i></td>
                        <td class='text-center'>
                            @include('livewire.common.buttons._delete')
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center text-danger">
                        <td colspan="7">Không có bản ghi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="w-100 clearfix my-2 mt-3">
                <center>
                    <button type="button" wire:click='save()' class="btn ml-1 btn-primary" id='btn-save'>Lưu</button>
                    <a href="{{ route('admin.product') }}">
                        <button type="button" class="btn btn-outline-primary mr-1">Quay lại</button>
                    </a>
                </center>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="modalAddImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới hình ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetValidate()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            @livewire('component.files',[
                            'model_name' => \App\Models\Job::class,
                            'model_id' => $editId??null,
                            'folder' => 'jobs',
                            'admin_id'=>auth()->id(),
                            'canUpload'=>true,
                            'displayUploadfile' => true,
                            'displayFile'=>true
                            ])
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id='close-modal' data-dismiss="modal" wire:click="resetValidate()">
                        Đóng
                    </button>
                    <button type="button" class="btn btn-primary" wire:click='saveImage()'>Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.common._modalDelete')
</div>
<script>
    $("document").ready(() => {
        window.livewire.on('close-modal', () => {
            $("#close-modal").click();
        });
        
    })

    $("#changeType").click(function(){
        @this.emit('changeType');
    });
    function chooseAvatar(id) {
        @this.emit('chooseAvatar', id);
    }
    

</script>