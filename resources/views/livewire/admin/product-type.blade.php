<div>
    <div class="body-content p-2">
        <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
            <div class="">
                <h4 class="m-0 ml-2">
                    Quản lý danh mục sản phẩm
                </h4>
            </div>
            <div class="paginate">
                <div class="d-flex">
                    <div class="">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                    </div>
                    <span class="px-2">/</span>
                    <div class="">
                        <div class="disable">Quản lý danh mục sản phẩm</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-2">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-4">
                                <label class="col-form-label">Tìm kiếm</label>
                                <input wire:model.debounce.1000ms="searchName" placeholder="Nhập tên danh mục" type="text" class="form-control">
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="filter d-flex align-items-center justify-content-between mb-2">
                    <button type="button" class="btn btn-outline-primary" wire:click="resetSearch()"><i class="fa fa-undo"></i> Làm mới</button>
                    <div>
                        <div style="float: left;text-align: center;">
                            <a href="#" data-toggle="modal" data-target="#modelCreateEditTicket" wire:click='create'>
                                <div class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Tạo mới
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div wire:loading class="loader"></div>
                <table class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                    <thead>
                        <tr role='row'>
                            <th class='text-center w-60'>STT</th>

                            <th class="{{ $key_name == 'name' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('name')">Danh mục sản phẩm</th>
                            <th class="{{ $key_name == 'parent_id' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('parent_id')">Loại phòng</th>
                            <th class='text-center w-120'>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $row)
                        <tr>
                            <td class='text-center'>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearchV2($row->name, $searchName) !!}</td>
                            <td>{{ $row->parent?$row->parent->name:'' }}</td>
                            <td class='text-center'>
                                <a type='button' class='btn btn-primary btn-sm' data-toggle="modal" data-target="#modelCreateEditTicket" wire:click='edit({{ $row }})' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
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
            </div>
            {{ $data->links() }}
        </div>
        {{-- Start modal --}}
        <div wire:ignore.self class="modal fade" id="modelCreateEditTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{$this->mode=='create'?"Thêm mới":($this->mode =='detail'?"Chi tiết":"Chỉnh sửa")}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetValidate()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Tên danh mục(<span style="color:red">*</span>)</label>
                            <input type="text" class="form-control" placeholder="Tên phân loại" wire:model.defer="name">
                            @error('name')
                            @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        <div class="form-group">
                            <label> Thuộc phòng(<span style="color:red">*</span>)</label><br>
                            <select id="select_parent_id" wire:model.defer="parent_id" class="form-control">
                                <option value="">Chọn loại phòng</option>
                                @foreach($pdTypeParentList as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal" wire:click="resetValidate()">
                            Đóng
                        </button>
                        <button type="button" class="btn btn-primary" wire:click='saveData'>Lưu
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.common._modalDelete')
    </div>
</div>
<script>
    $("document").ready(() => {
        window.livewire.on('closeModalCreateEdit', () => {
            $('#modelCreateEditTicket').modal('hide');
            @this.emit('resetInput');
        });;
    });
</script>